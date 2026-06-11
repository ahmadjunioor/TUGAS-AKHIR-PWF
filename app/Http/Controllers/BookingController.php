<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(Request $request)
    {
        $subcategoryId = $request->query('subcategory_id');
        if (! $subcategoryId) {
            return redirect()->route('home')->with('error', 'Pilih jasa terlebih dahulu.');
        }

        $subcategory = Subcategory::with(['category', 'packages'])->findOrFail($subcategoryId);
        $subcategory = $this->ensurePackages($subcategory);
        $cart = session('booking_cart', $this->emptyCart($subcategory));

        if (($cart['subcategory_id'] ?? null) != $subcategory->id) {
            $cart = $this->emptyCart($subcategory);
        }

        $cart['city'] = session('booking_city', $cart['city'] ?? 'Indonesia');
        $validComplaints = $this->complaintsFor($subcategory);
        $cart['complaints'] = array_values(array_intersect($cart['complaints'] ?? [], $validComplaints));
        session(['booking_cart' => $cart]);

        return view('booking.show', [
            'subcategory' => $subcategory,
            'cart' => $cart,
            'estimatedTotal' => $this->calculateTotal($cart),
            'complaints' => $validComplaints,
            'propertyTypes' => config('booking.property_types'),
        ]);
    }

    public function update(Request $request)
    {
        $subcategory = Subcategory::with('category')->findOrFail($request->subcategory_id);

        $items = [];
        $packages = $request->input('packages', []);
        foreach ($packages as $packageId => $qty) {
            $qty = (int) $qty;
            if ($qty < 1) {
                continue;
            }
            $pkg = $subcategory->packages()->find($packageId);
            if ($pkg) {
                $items[] = [
                    'package_id' => $pkg->id,
                    'name' => $pkg->name,
                    'price' => (float) $pkg->price,
                    'qty' => $qty,
                ];
            }
        }

        $propertyType = $request->input('property_type', 'rumah');
        $propertyConfig = config('booking.property_types.'.$propertyType, ['surcharge' => 0]);

        $cart = [
            'subcategory_id' => $subcategory->id,
            'category_id' => $subcategory->category_id,
            'subcategory_name' => $subcategory->name,
            'category_name' => $subcategory->category->name,
            'city' => session('booking_city', 'Indonesia'),
            'complaints' => array_values(array_filter($request->input('complaints', []))),
            'property_type' => $propertyType,
            'property_surcharge' => $propertyConfig['surcharge'],
            'items' => $items,
            'scheduled_date' => $request->input('scheduled_date'),
            'scheduled_time' => $request->input('scheduled_time', '08:00'),
        ];

        $cart['estimated_total'] = $this->calculateTotal($cart);
        session(['booking_cart' => $cart]);

        if ($request->input('action') === 'checkout') {
            if (empty($items)) {
                return back()->with('error', 'Pilih minimal satu layanan.');
            }
            if (! auth()->check()) {
                return redirect()->guest(route('login'))->with('info', 'Masuk terlebih dahulu untuk checkout.');
            }

            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function emptyCart(Subcategory $subcategory): array
    {
        return [
            'subcategory_id' => $subcategory->id,
            'category_id' => $subcategory->category_id,
            'subcategory_name' => $subcategory->name,
            'category_name' => $subcategory->category->name,
            'city' => session('booking_city', 'Indonesia'),
            'complaints' => [],
            'property_type' => 'rumah',
            'property_surcharge' => 0,
            'items' => [],
            'scheduled_date' => now()->addDay()->format('Y-m-d'),
            'scheduled_time' => '08:00',
            'estimated_total' => 0,
        ];
    }

    public function calculateTotal(array $cart): float
    {
        $subtotal = collect($cart['items'] ?? [])->sum(fn ($i) => $i['price'] * $i['qty']);

        return $subtotal + ($cart['property_surcharge'] ?? 0);
    }

    private function complaintsFor(Subcategory $subcategory): array
    {
        $bySubcategory = config('booking.complaints_by_subcategory', []);

        return $bySubcategory[$subcategory->name]
            ?? config('booking.default_complaints', ['Lainnya']);
    }

    private function ensurePackages(Subcategory $subcategory): Subcategory
    {
        if ($subcategory->packages->isNotEmpty()) {
            return $subcategory;
        }

        $defaults = config('booking.default_packages.'.$subcategory->name, []);

        foreach ($defaults as [$name, $desc, $price]) {
            $subcategory->packages()->create([
                'name' => $name,
                'description' => $desc,
                'price' => $price,
            ]);
        }

        return $subcategory->load('packages');
    }
}
