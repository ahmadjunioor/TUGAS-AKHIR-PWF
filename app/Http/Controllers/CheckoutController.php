<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('booking_cart');
        if (! $cart || empty($cart['items'])) {
            return redirect()->route('home')->with('error', 'Keranjang kosong. Pilih layanan terlebih dahulu.');
        }

        return view('checkout.index', [
            'cart' => $cart,
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $cart = session('booking_cart');
        if (! $cart || empty($cart['items'])) {
            return redirect()->route('home')->with('error', 'Keranjang kosong.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $scheduledAt = null;
        if (! empty($cart['scheduled_date'])) {
            $scheduledAt = $cart['scheduled_date'].' '.($cart['scheduled_time'] ?? '08:00').':00';
        }

        $description = $this->buildDescription($cart, $request->address, $request->notes);

        $serviceRequest = ServiceRequest::create([
            'customer_id' => Auth::id(),
            'category_id' => $cart['category_id'],
            'subcategory_id' => $cart['subcategory_id'],
            'title' => $request->title,
            'description' => $description,
            'address' => $request->address,
            'city' => $request->city,
            'max_budget' => $cart['estimated_total'],
            'estimated_total' => $cart['estimated_total'],
            'scheduled_at' => $scheduledAt,
            'booking_details' => $cart,
            'status' => 'open',
        ]);

        session()->forget('booking_cart');

        return redirect()->route('checkout.success', $serviceRequest->id)
            ->with('success', 'Pesanan berhasil! Menunggu penawaran dari vendor.');
    }

    public function success($id)
    {
        $request = ServiceRequest::where('customer_id', Auth::id())->findOrFail($id);

        return view('checkout.success', compact('request'));
    }

    private function buildDescription(array $cart, string $address, ?string $notes): string
    {
        $lines = [];
        $lines[] = 'Layanan: '.($cart['subcategory_name'] ?? '-');
        if (! empty($cart['complaints'])) {
            $lines[] = 'Keluhan: '.implode(', ', $cart['complaints']);
        }
        $lines[] = 'Tipe properti: '.($cart['property_type'] ?? '-');
        $lines[] = 'Alamat Lengkap: '.$address;
        $lines[] = 'Paket dipilih:';
        foreach ($cart['items'] as $item) {
            $lines[] = '- '.$item['name'].' x'.$item['qty'].' (Rp '.number_format($item['price'], 0, ',', '.').')';
        }
        if ($notes) {
            $lines[] = 'Catatan: '.$notes;
        }

        return implode("\n", $lines);
    }
}
