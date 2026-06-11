<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update vendor requirement documents.
     */
    public function updateVendorDocuments(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user->isVendor() || !$user->vendorProfile) {
            return Redirect::route('profile.edit')->with('error', 'Anda bukan merupakan vendor.');
        }

        $request->validate([
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'selfie_ktp' => 'nullable|file|mimes:jpg,jpeg,png|max:4096',
            'skck' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'domicile' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $vendorProfile = $user->vendorProfile;
        $validation = \App\Models\VendorValidation::firstOrCreate(['vendor_profile_id' => $vendorProfile->id]);

        $updates = [];
        $files = ['ktp' => 'ktp_path', 'selfie_ktp' => 'selfie_ktp_path', 'skck' => 'skck_path', 'domicile' => 'domicile_path', 'kk' => 'kk_path'];

        foreach ($files as $inputName => $dbField) {
            if ($request->hasFile($inputName)) {
                if ($validation->$dbField && \Illuminate\Support\Facades\Storage::disk('public')->exists($validation->$dbField)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($validation->$dbField);
                }
                $updates[$dbField] = $request->file($inputName)->store('vendor/validations', 'public');
            }
        }

        if (!empty($updates)) {
            $validation->update($updates);
            $vendorProfile->update(['status' => 'pending']);
            return Redirect::route('profile.edit')->with('success', 'Dokumen persyaratan berhasil diperbarui dan sedang menunggu verifikasi ulang.');
        }

        return Redirect::route('profile.edit')->with('info', 'Tidak ada dokumen yang diubah.');
    }
}
