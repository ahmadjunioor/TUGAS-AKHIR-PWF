<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceRequest;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard', $request->only(['subcategory_id', 'city']));
        }

        return view('welcome');
    }

    public function services(Request $request)
    {
        if ($request->filled('subcategory_id')) {
            session(['booking_city' => $request->input('city', 'Indonesia')]);

            return redirect()->route('booking.show', [
                'subcategory_id' => $request->subcategory_id,
            ]);
        }

        return view('home', $this->bookingCatalogData());
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }

        if ($request->filled('subcategory_id')) {
            session(['booking_city' => $request->input('city', 'Indonesia')]);

            return redirect()->route('booking.show', [
                'subcategory_id' => $request->subcategory_id,
            ]);
        }

        $requests = ServiceRequest::with(['quotations.vendorProfile', 'category', 'subcategory'])
            ->where('customer_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard', array_merge(
            $this->bookingCatalogData(),
            compact('requests')
        ));
    }

    private function bookingCatalogData(): array
    {
        $dbCities = \Laravolt\Indonesia\Models\City::orderBy('name')->pluck('name')->map(function($name) {
            return ucwords(strtolower($name));
        })->toArray();

        $cities = array_merge(['Indonesia'], $dbCities);

        return [
            'categories' => Category::with('subcategories')->orderBy('name')->get(),
            'subcategories' => Subcategory::with('category')->orderBy('name')->get(),
            'cities' => $cities,
        ];
    }
}
