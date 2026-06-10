<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view(config('app.theme').'.pages.settings.index');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'logo_pdf_title' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:50',
            'telephone' => 'nullable|string|max:50',
            'manager_name' => 'nullable|string|max:255',
            'navbar_color' => 'nullable|string|max:7',
            'sidebar_color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'logo_pdf_title.required' => 'اسم المؤسسة مطلوب',
            'logo.image' => 'يجب اختيار صورة صالحة للشعار',
            'logo.max' => 'حجم الشعار يجب ألا يتجاوز 2 ميجابايت',
        ]);

        Setting::set('logo_pdf_title', $data['logo_pdf_title']);
        Setting::set('phone_number', $data['phone_number'] ?? '');
        Setting::set('telephone', $data['telephone'] ?? '');
        Setting::set('manager_name', $data['manager_name'] ?? '');
        Setting::set('navbar_color', $request->input('navbar_color', '#ffffff'));
        Setting::set('sidebar_color', $request->input('sidebar_color', '#1e293b'));

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . $logoFile->getClientOriginalName();
            // Store directly in public/uploads for easier access without symlinks
            $logoFile->move(public_path('uploads'), $logoName);
            Setting::set('logo', '/uploads/' . $logoName);
        }

        flash('تم حفظ الإعدادات بنجاح.', 'alert alert-success');
        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة',
            'new_password.min' => 'يجب ألا تقل كلمة المرور الجديدة عن 8 أحرف',
            'new_password.confirmed' => 'كلمة المرور الجديدة غير متطابقة مع تأكيد كلمة المرور',
        ]);

        $user = auth()->user();

        if (!\Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة'])->withInput();
        }

        $user->update([
            'password' => \Hash::make($data['new_password'])
        ]);

        flash('تم تغيير كلمة المرور بنجاح.', 'alert alert-success');
        return redirect()->back();
    }
}
