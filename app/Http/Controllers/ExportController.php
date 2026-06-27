<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Order;
use App\Models\Product;
use App\Models\Returns;
use App\Models\Expenses;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\StakeHolder;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    /**
     * Helper function to stream CSV response with UTF-8 BOM for Arabic support in Excel.
     */
    private function downloadCsv($filename, $headers, $rows)
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM to fix Arabic characters in Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write column headers
            fputcsv($handle, $headers);

            // Write data rows
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // 1. الموردين (Suppliers)
    public function exportSuppliers(Request $request)
    {
        $suppliers = StakeHolder::where('type', 'supplier')->latest()->get();
        $headers = ['كود المورد', 'الاسم', 'الهاتف', 'العنوان', 'تاريخ الإضافة'];
        $rows = [];
        foreach ($suppliers as $supplier) {
            $rows[] = [
                $supplier->id,
                $supplier->name ?? '-',
                $supplier->phone ?? '-',
                $supplier->address ?? '-',
                $supplier->created_at ? $supplier->created_at->format('Y-m-d') : '-'
            ];
        }
        return $this->downloadCsv('suppliers_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 2. العملاء (Customers)
    public function exportCustomers(Request $request)
    {
        $customers = StakeHolder::where('type', 'customer')->latest()->get();
        $headers = ['كود العميل', 'الاسم', 'الهاتف', 'العنوان', 'تاريخ الإضافة'];
        $rows = [];
        foreach ($customers as $customer) {
            $rows[] = [
                $customer->id,
                $customer->name ?? '-',
                $customer->phone ?? '-',
                $customer->address ?? '-',
                $customer->created_at ? $customer->created_at->format('Y-m-d') : '-'
            ];
        }
        return $this->downloadCsv('customers_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 3. المنتجات (Products)
    public function exportProducts(Request $request)
    {
        $products = Product::latest()->get();
        $headers = ['كود المنتج', 'الاسم', 'سعر الشراء', 'سعر البيع', 'تاريخ الإضافة'];
        $rows = [];
        foreach ($products as $product) {
            $rows[] = [
                $product->id,
                $product->name ?? '-',
                $product->purchasing_price ?? 0,
                $product->sale_price ?? 0,
                $product->created_at ? $product->created_at->format('Y-m-d') : '-'
            ];
        }
        return $this->downloadCsv('products_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 4. المخزن (Stocks)
    public function exportStocks(Request $request)
    {
        $filter_data = $request->all();
        $stocks = Stock::query()->with(['product', 'supplier' => function($q){ $q->withTrashed(); }]);

        if (isset($filter_data['filter']['product_id']) && $filter_data['filter']['product_id'] !== '') {
            $stocks->where('product_id', $filter_data['filter']['product_id']);
        }
        if (isset($filter_data['filter']['supplier_id']) && $filter_data['filter']['supplier_id'] !== '') {
            $stocks->where('supplier_id', $filter_data['filter']['supplier_id']);
        }
        if (isset($filter_data['filter']['stock_status']) && $filter_data['filter']['stock_status'] !== '') {
            $status = $filter_data['filter']['stock_status'];
            if ($status === 'out_of_stock') {
                $stocks->where('quantity', '<=', 0);
            } elseif ($status === 'low_5') {
                $stocks->where('quantity', '<=', 5);
            } elseif ($status === 'low_10') {
                $stocks->where('quantity', '<=', 10);
            } elseif ($status === 'low_20') {
                $stocks->where('quantity', '<=', 20);
            } elseif ($status === 'low_50') {
                $stocks->where('quantity', '<=', 50);
            }
        }
        if (isset($filter_data['filter']['price']) && $filter_data['filter']['price'] !== '') {
            if ($filter_data['filter']['price'] == 'high-price') {
                $stocks->orderBy('sale_price', 'desc');
            } elseif ($filter_data['filter']['price'] == 'low-price') {
                $stocks->orderBy('sale_price', 'asc');
            }
        } else {
            $stocks->orderBy('id', 'desc');
        }

        $items = $stocks->get();
        $headers = ['كود الصنف', 'اسم الصنف', 'الكمية', 'سعر البيع', 'سعر الشراء', 'الربح المتوقع للوحدة', 'المورد', 'تاريخ التحديث'];
        $rows = [];
        foreach ($items as $index => $item) {
            $rows[] = [
                $index + 1,
                $item->product ? $item->product->name : '-',
                $item->quantity ?? 0,
                $item->sale_price ?? 0,
                $item->purchasing_price ?? 0,
                ($item->sale_price ?? 0) - ($item->purchasing_price ?? 0),
                $item->supplier ? $item->supplier->name : '-',
                $item->updated_at ? $item->updated_at->format('Y-m-d') : '-'
            ];
        }
        return $this->downloadCsv('stocks_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 5. فواتير المبيعات (Orders)
    public function exportOrders(Request $request)
    {
        $filter_data = $request->all();
        $orders = Order::query()->where('type', 'sales')->with('customer');

        if (isset($filter_data['search']) && $filter_data['search'] !== '') {
            $orders->where('order_number', 'like', '%' . $filter_data['search'] . '%');
        }
        if (isset($filter_data['filter']['customer_id']) && $filter_data['filter']['customer_id'] !== '') {
            $orders->where('customer_id', $filter_data['filter']['customer_id']);
        }
        if (isset($filter_data['filter']['sort']) && $filter_data['filter']['sort'] !== '') {
            if ($filter_data['filter']['sort'] == 'sort_desc') {
                $orders->orderBy('id', 'desc');
            } else {
                $orders->orderBy('id', 'asc');
            }
        } else {
            $orders->orderBy('id', 'desc');
        }

        $items = $orders->get();
        $headers = ['رقم الفاتورة', 'العميل', 'الخصم', 'إجمالي الفاتورة', 'حالة الدفع', 'تاريخ الفاتورة'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->order_number ?? $item->id,
                $item->customer ? $item->customer->name : '-',
                $item->discount ?? 0,
                $item->total_price ?? 0,
                $item->payment_type == 'cashe' ? 'كاش' : 'دفعات',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-'
            ];
        }
        return $this->downloadCsv('sales_invoices_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 6. فواتير المشتريات (Purchasing Invoices)
    public function exportPurchasingInvoices(Request $request)
    {
        $filter_data = $request->all();
        $orders = Order::query()->where('type', 'purchasing')->with('supplier');

        if (isset($filter_data['search']) && $filter_data['search'] !== '') {
            $orders->where('order_number', 'like', '%' . $filter_data['search'] . '%');
        }
        if (isset($filter_data['filter']['supplier_id']) && $filter_data['filter']['supplier_id'] !== '') {
            $orders->where('supplier_id', $filter_data['filter']['supplier_id']);
        }
        if (isset($filter_data['filter']['sort']) && $filter_data['filter']['sort'] !== '') {
            if ($filter_data['filter']['sort'] == 'sort_desc') {
                $orders->orderBy('id', 'desc');
            } else {
                $orders->orderBy('id', 'asc');
            }
        } else {
            $orders->orderBy('id', 'desc');
        }

        $items = $orders->get();
        $headers = ['رقم الفاتورة', 'المورد', 'الخصم', 'إجمالي الفاتورة', 'تاريخ الفاتورة'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->order_number ?? $item->id,
                $item->supplier ? $item->supplier->name : '-',
                $item->discount ?? 0,
                $item->total_price ?? 0,
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-'
            ];
        }
        return $this->downloadCsv('purchasing_invoices_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 7. المصروفات (Expenses)
    public function exportExpenses(Request $request)
    {
        $expenses = Expenses::query();
        if ($request->filled('from')) {
            $expenses->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $expenses->whereDate('created_at', '<=', $request->to);
        }
        $items = $expenses->latest()->get();

        $headers = ['كود المصروف', 'اسم المصروف', 'المبلغ', 'البيان/التفاصيل', 'التاريخ'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->id,
                $item->title ?? '-',
                $item->amount ?? 0,
                $item->description ?? '-',
                $item->created_at ? $item->created_at->format('Y-m-d') : '-'
            ];
        }
        return $this->downloadCsv('expenses_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 8. المرتجعات (Returns)
    public function exportReturns(Request $request)
    {
        $returns = Returns::query()->with('customer');
        if ($request->filled('search')) {
            $returns->where('id', $request->search);
        }
        if ($request->filled('customer_filter')) {
            $returns->where('customer_id', $request->customer_filter);
        }
        if ($request->filled('from')) {
            $returns->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $returns->whereDate('created_at', '<=', $request->to);
        }
        $items = $returns->latest()->get();

        $headers = ['رقم إذن المرتجع', 'العميل', 'المبلغ الإجمالي', 'التاريخ'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->id,
                $item->customer ? $item->customer->name : '-',
                $item->total_price ?? 0,
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-'
            ];
        }
        return $this->downloadCsv('returns_export_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 9. دفوعات العملاء (Customer Payments)
    public function exportCustomerPayments(Request $request)
    {
        $payments = OrderPayment::query()->whereHas('stakeHolder', function($q){
            $q->where('type', 'customer');
        })->with('stakeHolder');

        if ($request->filled('search')) {
            $payments->where('id', $request->search);
        }
        if ($request->filled('customer_filter')) {
            $payments->where('stake_holder_id', $request->customer_filter);
        }
        $items = $payments->latest()->get();

        $headers = ['رقم السند', 'العميل', 'القيمة المدفوعة', 'النوع', 'التاريخ'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->id,
                $item->stakeHolder ? $item->stakeHolder->name : '-',
                $item->value ?? 0,
                $item->type ?? 'سند قبض',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-'
            ];
        }
        return $this->downloadCsv('customer_payments_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 10. دفوعات الموردين (Supplier Payments)
    public function exportSupplierPayments(Request $request)
    {
        $payments = OrderPayment::query()->whereHas('stakeHolder', function($q){
            $q->where('type', 'supplier');
        })->with('stakeHolder');

        if ($request->filled('search')) {
            $payments->where('id', $request->search);
        }
        if ($request->filled('supplier_filter')) {
            $payments->where('stake_holder_id', $request->supplier_filter);
        }
        $items = $payments->latest()->get();

        $headers = ['رقم السند', 'المورد', 'القيمة المدفوعة', 'النوع', 'التاريخ'];
        $rows = [];
        foreach ($items as $item) {
            $rows[] = [
                $item->id,
                $item->stakeHolder ? $item->stakeHolder->name : '-',
                $item->value ?? 0,
                $item->type ?? 'سند صرف',
                $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-'
            ];
        }
        return $this->downloadCsv('supplier_payments_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 11. ديون العملاء (Customer Debts)
    public function exportCustomerDebts(Request $request)
    {
        $customers = StakeHolder::where('type', 'customer')->get();
        $headers = ['كود العميل', 'اسم العميل', 'إجمالي الفواتير', 'إجمالي المدفوعات', 'المتبقي (الديون)'];
        $rows = [];
        foreach ($customers as $customer) {
            $total_orders = Order::where('customer_id', $customer->id)->where('type', 'sales')->sum('total_price');
            $total_payments = OrderPayment::where('stake_holder_id', $customer->id)->sum('value');
            $debt = $total_orders - $total_payments;
            if ($debt > 0) {
                $rows[] = [
                    $customer->id,
                    $customer->name,
                    $total_orders,
                    $total_payments,
                    $debt
                ];
            }
        }
        return $this->downloadCsv('customer_debts_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    // 12. ديون الموردين (Supplier Debts)
    public function exportSupplierDebts(Request $request)
    {
        $suppliers = StakeHolder::where('type', 'supplier')->get();
        $headers = ['كود المورد', 'اسم المورد', 'إجمالي الفواتير', 'إجمالي المدفوعات', 'المتبقي للمورد'];
        $rows = [];
        foreach ($suppliers as $supplier) {
            $total_orders = Order::where('supplier_id', $supplier->id)->where('type', 'purchasing')->sum('total_price');
            $total_payments = OrderPayment::where('stake_holder_id', $supplier->id)->sum('value');
            $debt = $total_orders - $total_payments;
            if ($debt > 0) {
                $rows[] = [
                    $supplier->id,
                    $supplier->name,
                    $total_orders,
                    $total_payments,
                    $debt
                ];
            }
        }
        return $this->downloadCsv('supplier_debts_' . date('Y-m-d') . '.csv', $headers, $rows);
    }
}
