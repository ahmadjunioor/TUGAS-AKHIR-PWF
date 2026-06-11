<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorProfile;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingVendors = VendorProfile::with(['category', 'subcategory', 'user', 'validation'])->where('status', 'pending')->get();
        $approvedVendors = VendorProfile::with(['category', 'subcategory', 'user', 'validation'])->where('status', 'approved')->get();
        $rejectedVendors = VendorProfile::with(['category', 'subcategory', 'user', 'validation'])->where('status', 'rejected')->get();
        
        $disputedTasks = \App\Models\ServiceRequest::with(['customer', 'quotations.vendorProfile'])
            ->where('status', 'disputed')
            ->get();
        
        return view('admin.dashboard', compact('pendingVendors', 'approvedVendors', 'rejectedVendors', 'disputedTasks'));
    }

    public function approveVendor($id)
    {
        $vendor = VendorProfile::with('user')->findOrFail($id);
        $vendor->update(['status' => 'approved']);
        $vendor->user->update(['role' => 'vendor']);

        return back()->with('success', 'Vendor '.$vendor->business_name.' berhasil disetujui!');
    }

    public function rejectVendor($id)
    {
        $vendor = VendorProfile::findOrFail($id);
        $vendor->update(['status' => 'rejected']);

        return back()->with('success', 'Vendor ' . $vendor->business_name . ' ditolak!');
    }

    public function resolveDispute(Request $request, $id)
    {
        $req = \App\Models\ServiceRequest::findOrFail($id);
        $action = $request->input('action'); 
        $acceptedQuote = $req->quotations()->where('status', 'accepted')->first();

        if (!$acceptedQuote) {
            return back()->with('error', 'Penawaran tidak ditemukan untuk diselesaikan.');
        }

        if ($action == 'refund') {
            $customer = $req->customer;
            $customer->balance += $acceptedQuote->amount;
            $customer->save();
            
            \App\Models\Transaction::create([
                'user_id' => $customer->id,
                'amount' => $acceptedQuote->amount,
                'type' => 'refund',
                'description' => 'Pengembalian dana (Sengketa) Jasa: ' . $req->title,
                'reference_id' => $req->id
            ]);
            $req->update(['status' => 'cancelled']);

        } elseif ($action == 'release') {
            $vendorUser = $acceptedQuote->vendorProfile->user;
            $vendorUser->balance += $acceptedQuote->amount;
            $vendorUser->save();

            \App\Models\Transaction::create([
                'user_id' => $vendorUser->id,
                'amount' => $acceptedQuote->amount,
                'type' => 'escrow_release',
                'description' => 'Pencairan dana admin (Sengketa) Jasa: ' . $req->title,
                'reference_id' => $acceptedQuote->id
            ]);
            $req->update(['status' => 'completed']);
        }

        return back()->with('success', 'Sengketa berhasil diproses.');
    }
}
