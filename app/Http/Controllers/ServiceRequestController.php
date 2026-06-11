<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function create()
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();

        return view('service_requests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'max_budget' => 'nullable|numeric|min:0',
        ]);

        ServiceRequest::create([
            'customer_id' => Auth::id(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'city' => $request->city,
            'max_budget' => $request->max_budget,
            'status' => 'open',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Permintaan jasa berhasil dibuat! Tunggu hingga 5 penawaran dari vendor terpercaya.');
    }

    public function startWork($id)
    {
        $req = ServiceRequest::findOrFail($id);
        $vendorProfile = Auth::user()->vendorProfile;

        if (! $this->isAssignedVendor($req, $vendorProfile?->id)) {
            return back()->with('error', 'Anda tidak berhak memulai pekerjaan ini.');
        }

        if ($req->status !== 'assigned') {
            return back()->with('error', 'Pekerjaan belum siap dimulai.');
        }

        $req->update(['status' => 'in_progress']);

        return back()->with('success', 'Status diubah: Sedang dikerjakan.');
    }

    public function finishWork($id)
    {
        $req = ServiceRequest::findOrFail($id);
        $vendorProfile = Auth::user()->vendorProfile;

        if (! $this->isAssignedVendor($req, $vendorProfile?->id)) {
            return back()->with('error', 'Anda tidak berhak menyelesaikan pekerjaan ini.');
        }

        if ($req->status !== 'in_progress') {
            return back()->with('error', 'Pekerjaan harus dalam status sedang dikerjakan.');
        }

        $req->update(['status' => 'awaiting_confirmation']);

        return back()->with('success', 'Tugas ditandai selesai. Menunggu konfirmasi pelanggan.');
    }

    public function confirmCompletion($id)
    {
        $req = ServiceRequest::with('quotations.vendorProfile.user')->findOrFail($id);

        if ($req->customer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengonfirmasi pekerjaan ini.');
        }

        if ($req->status !== 'awaiting_confirmation') {
            return back()->with('error', 'Belum ada laporan penyelesaian dari vendor.');
        }

        $acceptedQuote = $req->acceptedQuotation();
        if (! $acceptedQuote) {
            return back()->with('error', 'Penawaran yang diterima tidak ditemukan.');
        }

        $req->update(['status' => 'completed']);

        $vendorUser = $acceptedQuote->vendorProfile->user;
        $vendorUser->balance += $acceptedQuote->amount;
        $vendorUser->save();

        Transaction::create([
            'user_id' => $vendorUser->id,
            'amount' => $acceptedQuote->amount,
            'type' => 'escrow_release',
            'description' => 'Pencairan dana Jasa: '.$req->title,
            'reference_id' => $acceptedQuote->id,
        ]);

        return back()->with('success', 'Konfirmasi berhasil. Dana telah diteruskan ke vendor.');
    }

    public function reportDispute(Request $request, $id)
    {
        $request->validate([
            'dispute_notes' => 'required|string',
            'dispute_photo' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $req = ServiceRequest::findOrFail($id);

        if ($req->customer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak melaporkan sengketa untuk pekerjaan ini.');
        }

        if (! in_array($req->status, ['assigned', 'in_progress', 'awaiting_confirmation'], true)) {
            return back()->with('error', 'Status pekerjaan tidak memungkinkan pelaporan sengketa.');
        }

        $photoPath = $request->file('dispute_photo')->store('disputes', 'public');

        $req->update([
            'status' => 'disputed',
            'dispute_notes' => $request->dispute_notes,
            'dispute_photo_path' => $photoPath,
        ]);

        return back()->with('success', 'Laporan sengketa dikirim. Superadmin akan meninjau dalam 1x24 jam.');
    }

    private function isAssignedVendor(ServiceRequest $req, ?int $vendorProfileId): bool
    {
        if (! $vendorProfileId) {
            return false;
        }

        return $req->quotations()
            ->where('vendor_profile_id', $vendorProfileId)
            ->where('status', 'accepted')
            ->exists();
    }
}
