<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorProfile = Auth::user()->vendorProfile;

        if (! $vendorProfile) {
            return redirect()->route('vendor.register');
        }

        if ($vendorProfile->status !== 'approved') {
            return view('vendor.pending_verification', compact('vendorProfile'));
        }

        $openRequests = ServiceRequest::with(['category', 'customer'])
            ->withCount('quotations')
            ->where('status', 'open')
            ->where('category_id', $vendorProfile->category_id)
            ->whereDoesntHave('quotations', function ($q) use ($vendorProfile) {
                $q->where('vendor_profile_id', $vendorProfile->id);
            })
            ->orderByDesc('created_at')
            ->get()
            ->filter(function ($req) use ($vendorProfile) {
                return \App\Models\VendorProfile::cityMatches($req->city, $vendorProfile->city);
            });

        $myJobs = ServiceRequest::with(['customer', 'quotations' => function ($q) use ($vendorProfile) {
            $q->where('vendor_profile_id', $vendorProfile->id)->where('status', 'accepted');
        }])
            ->whereHas('quotations', function ($q) use ($vendorProfile) {
                $q->where('vendor_profile_id', $vendorProfile->id)->where('status', 'accepted');
            })
            ->whereIn('status', ['assigned', 'in_progress', 'awaiting_confirmation'])
            ->orderByDesc('created_at')
            ->get();

        return view('vendor.dashboard', [
            'requests' => $openRequests,
            'myJobs' => $myJobs,
            'vendorProfile' => $vendorProfile,
        ]);
    }
}
