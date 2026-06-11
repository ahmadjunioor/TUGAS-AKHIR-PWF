<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\VendorProfile;
use App\Models\VendorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorRegistrationController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user->vendorProfile && $user->vendorProfile->status === 'pending') {
            return view('vendor.pending_verification', ['vendorProfile' => $user->vendorProfile]);
        }

        if ($user->vendorProfile && $user->vendorProfile->status === 'approved') {
            return redirect()->route('vendor.dashboard');
        }

        $categories = Category::with('subcategories')->orderBy('name')->get();
        $provinces = \Laravolt\Indonesia\Models\Province::all();

        return view('vendor.register', compact('categories', 'provinces'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->vendorProfile && $user->vendorProfile->status === 'pending') {
            return redirect()->route('vendor.dashboard');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'sub_district' => 'required|string',
            'phone' => 'required|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'selfie_ktp' => 'required|file|mimes:jpg,jpeg,png|max:4096',
            'skck' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'domicile' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('vendor/logos', 'public')
            : null;

        if ($user->vendorProfile && $user->vendorProfile->status === 'rejected') {
            $profile = $user->vendorProfile;
            $profile->update([
                'business_name' => $validated['business_name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'district' => $validated['district'],
                'sub_district' => $validated['sub_district'],
                'phone_number' => $validated['phone'],
                'business_email' => $validated['business_email'] ?? $user->email,
                'full_address' => $validated['address'],
                'logo_path' => $logoPath ?? $profile->logo_path,
                'status' => 'pending',
            ]);
        } else {
            $profile = VendorProfile::create([
                'user_id' => $user->id,
                'business_name' => $validated['business_name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'subcategory_id' => $validated['subcategory_id'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'district' => $validated['district'],
                'sub_district' => $validated['sub_district'],
                'phone_number' => $validated['phone'],
                'business_email' => $validated['business_email'] ?? $user->email,
                'full_address' => $validated['address'],
                'logo_path' => $logoPath,
                'status' => 'pending',
            ]);
        }

        VendorValidation::updateOrCreate(
            ['vendor_profile_id' => $profile->id],
            [
                'ktp_path' => $request->file('ktp')->store('vendor/validations', 'public'),
                'selfie_ktp_path' => $request->file('selfie_ktp')->store('vendor/validations', 'public'),
                'skck_path' => $request->file('skck')->store('vendor/validations', 'public'),
                'domicile_path' => $request->hasFile('domicile')
                    ? $request->file('domicile')->store('vendor/validations', 'public')
                    : null,
                'kk_path' => $request->hasFile('kk')
                    ? $request->file('kk')->store('vendor/validations', 'public')
                    : null,
            ]
        );

        $user->update(['role' => 'vendor']);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Profil vendor berhasil dikirim. Tim admin akan memverifikasi dalam 1-2 hari kerja.');
    }
}
