<!DOCTYPE html>
<html lang="ar" class="light-style layout-menu-fixed" dir="rtl">
<head>
    <meta charset="utf-8" />
    <style>
        .table tr {
            border: 1px solid #444;
        }
        .table td, .table th {
            border: 1px solid #cac7c7;
            text-align: center;
        }
        .table th {
            background-color: #2e7d32;
            color: #ffffff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table style="width: 100%; border: none;">
        <tr>
            <td style="text-align: right; width: 60%; border: none;">
                @if(get_setting('logo'))
                    <img src="{{ public_path(get_setting('logo')) }}" alt="Logo" style="max-height: 55px; max-width: 150px; object-fit: contain;">
                @endif
                <div style="margin-top: 5px;">
                    <strong style="font-size: 15px;">{{ get_setting('logo_pdf_title', env('logo_pdf_title')) }}</strong>
                    <p style="margin: 3px 0 0 0; font-size: 11px;">(م/ت) {{ get_setting('phone_number', env('phone_number')) }} @if(get_setting('telephone')) - {{ get_setting('telephone') }} @endif</p>
                </div>
            </td>
            <td style="text-align: left; width: 40%; border: none; font-size: 11px; vertical-align: top;">
                <strong>تاريخ التحرير: </strong> {{ date('Y-m-d') }}
            </td>
        </tr>
    </table>

    <hr style="border-top: 1px solid #ccc; margin: 15px 0;" />

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #2e7d32; margin: 0; font-size: 18px; text-align: center;">تقرير المطلوب تحصيله من العملاء</h2>
    </div>

    <!-- Summary Box -->
    <table style="width: 100%; margin-bottom: 20px; border: 1px solid #2e7d32; background-color: #e8f5e9; padding: 10px;">
        <tr>
            <td style="text-align: center; font-size: 14px; font-weight: bold; border: none; color: #2e7d32; width: 100%;">
                إجمالي المطلوب تحصيله: {{ formate_price($total_debts) }}
            </td>
        </tr>
    </table>

    <!-- Table Details -->
    <table class="table" cellpadding="6px" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">#</th>
                <th style="width: 12%; text-align: center;">كود العميل</th>
                <th style="width: 27%; text-align: center;">اسم العميل</th>
                <th style="width: 15%; text-align: center;">الهاتف</th>
                <th style="width: 18%; text-align: center;">الرصيد المبدأي</th>
                <th style="width: 12%; text-align: center;">المستحق</th>
                <th style="width: 10%; text-align: center;">آخر حركة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td style="width: 6%; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="width: 12%; text-align: center;">{{ $customer->id }}</td>
                    <td style="width: 27%; text-align: right; padding-right: 5px;">{{ $customer->name }}</td>
                    <td style="width: 15%; text-align: center;">{{ $customer->phone ?: '-' }}</td>
                    <td style="width: 18%; text-align: center;">{{ formate_price($customer->balance) }}</td>
                    <td style="width: 12%; text-align: center; font-weight: bold; color: #d32f2f;">{{ formate_price(abs($customer->current_balance)) }}</td>
                    <td style="width: 10%; text-align: center;">{{ $customer->last_transaction_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr style="border-top: 1px dashed #ccc; margin: 20px 0;" />

    <!-- Footer signature -->
    <table style="width: 100%; margin-top: 30px; border: none;">
        <tr>
            <td style="width: 50%; text-align: right; border: none; font-size: 11px;">
                <strong>توقيع المحاسب:</strong> .......................
            </td>
            <td style="width: 50%; text-align: left; border: none; font-size: 11px;">
                <strong>توقيع المدير العام:</strong> .......................
            </td>
        </tr>
    </table>
</body>
</html>
