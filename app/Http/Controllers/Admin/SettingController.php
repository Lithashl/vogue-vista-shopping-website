<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'qris_merchant_name' => 'nullable|string|max:100',
            'qris_nmid'          => 'nullable|string|max:30',
            'qris_image'         => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('qris_image')) {
            $file = $request->file('qris_image');
            $filename = 'qris.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/qris'), $filename);
            Setting::set('qris_image', 'uploads/qris/' . $filename);
        }

        if ($request->filled('qris_merchant_name')) {
            Setting::set('qris_merchant_name', $request->qris_merchant_name);
        }

        if ($request->has('qris_nmid')) {
            Setting::set('qris_nmid', $request->qris_nmid);
        }

        return redirect()->back()->with('message', 'Settings saved successfully.');
    }
}
