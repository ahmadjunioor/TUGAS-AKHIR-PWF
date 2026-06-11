<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string|max:1000',
        ]);

        $vendorProfile = Auth::user()->vendorProfile;
        if (! $vendorProfile || $vendorProfile->status !== 'approved') {
            return back()->with('error', 'Silakan daftar dan tunggu verifikasi profil vendor Anda terlebih dahulu.');
        }

        $serviceRequest = ServiceRequest::findOrFail($id);

        if (! \App\Models\VendorProfile::cityMatches($serviceRequest->city, $vendorProfile->city)) {
            return back()->with('error', 'Lokasi operasional Anda tidak sesuai dengan lokasi permintaan jasa.');
        }

        if ($serviceRequest->category_id !== $vendorProfile->category_id) {
            return back()->with('error', 'Anda hanya dapat memberikan penawaran pada permintaan jasa yang sesuai dengan kategori Anda.');
        }

        if ($serviceRequest->status !== 'open') {
            return back()->with('error', 'Permintaan jasa ini sudah ditutup untuk penawaran baru.');
        }

        if ($serviceRequest->quotations()->count() >= 5) {
            return back()->with('error', 'Kuota penawaran (maksimal 5) sudah penuh.');
        }

        if ($serviceRequest->quotations()->where('vendor_profile_id', $vendorProfile->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan penawaran untuk permintaan ini.');
        }

        Quotation::create([
            'service_request_id' => $serviceRequest->id,
            'vendor_profile_id' => $vendorProfile->id,
            'amount' => $request->amount,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        if ($serviceRequest->quotations()->count() >= 5) {
            $serviceRequest->update(['status' => 'bidding_closed']);
        }

        return back()->with('success', 'Penawaran harga berhasil dikirimkan ke pelanggan!');
    }

    public function accept(Request $request, $id)
    {
        $quotation = Quotation::with(['serviceRequest', 'vendorProfile'])->findOrFail($id);
        $serviceRequest = $quotation->serviceRequest;
        $customer = Auth::user();

        if ($serviceRequest->customer_id !== $customer->id) {
            return back()->with('error', 'Anda tidak berhak menerima penawaran ini.');
        }

        if (! in_array($serviceRequest->status, ['open', 'bidding_closed'], true)) {
            return back()->with('error', 'Permintaan ini sudah tidak menerima penawaran baru.');
        }

        if ($quotation->status !== 'pending') {
            return back()->with('error', 'Penawaran ini sudah tidak tersedia.');
        }

        if ($customer->balance < $quotation->amount) {
            return back()->with('error', 'Saldo virtual tidak mencukupi. Silakan top up terlebih dahulu.');
        }

        $customer->balance -= $quotation->amount;
        $customer->save();

        $quotation->update(['status' => 'accepted']);
        $serviceRequest->quotations()->where('status', 'pending')->update(['status' => 'rejected']);
        $serviceRequest->update(['status' => 'assigned']);

        Transaction::create([
            'user_id' => $customer->id,
            'amount' => $quotation->amount,
            'type' => 'escrow_hold',
            'description' => 'Dana ditahan (Escrow) untuk Jasa: '.$serviceRequest->title,
            'reference_id' => $quotation->id,
        ]);

        return back()->with('success', 'Pembayaran berhasil! Dana ditahan di sistem. Vendor akan segera menghubungi Anda.');
    }
}
