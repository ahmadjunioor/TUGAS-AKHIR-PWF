<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="flex mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-[#de2169] transition font-medium">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-slate-400 font-medium ml-1">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Checkout Pesanan</h1>
                <p class="text-slate-500 mt-2 text-base">Pastikan detail pesanan sudah benar sebelum dikirim ke vendor.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Order & Delivery details -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                    <!-- Ringkasan Layanan -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-5">
                                <div>
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $cart['category_name'] }}</span>
                                    <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ $cart['subcategory_name'] }}</h2>
                                </div>
                                <span class="bg-pink-50 text-[#de2169] text-xs font-bold px-3 py-1.5 rounded-xl border border-pink-100">
                                    Layanan
                                </span>
                            </div>

                            <!-- Items List -->
                            <div class="space-y-4">
                                @foreach($cart['items'] as $item)
                                    <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-pink-100/50 flex items-center justify-center text-[#de2169]">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $item['name'] }}</p>
                                                <p class="text-xs text-slate-500">Kuantitas: {{ $item['qty'] }}</p>
                                            </div>
                                        </div>
                                        <span class="font-extrabold text-slate-900">
                                            Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach

                                @if(($cart['property_surcharge'] ?? 0) > 0)
                                    <div class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 flex items-center justify-center text-slate-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-700">Tambahan Properti (Apartemen)</p>
                                                <p class="text-xs text-slate-500">Biaya surcharge gedung</p>
                                            </div>
                                        </div>
                                        <span class="font-bold text-slate-800">
                                            Rp {{ number_format($cart['property_surcharge'], 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            @if(!empty($cart['complaints']))
                                <div class="mt-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-3">
                                    <div class="text-amber-500 mt-0.5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Keluhan / Catatan Detail</p>
                                        <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ implode(', ', $cart['complaints']) }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Schedule info -->
                            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap gap-4 items-center text-sm text-slate-500">
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#de2169]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-semibold text-slate-700">{{ $cart['scheduled_date'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#de2169]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-semibold text-slate-700">{{ $cart['scheduled_time'] }} WIB</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Checkout -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#de2169]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Detail Pengiriman
                            </h2>

                            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-slate-700">
                                            Judul Permintaan
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <input
                                                type="text"
                                                name="title"
                                                value="{{ $cart['subcategory_name'] }} - {{ $cart['city'] }}"
                                                required
                                                class="w-full pl-11 rounded-2xl border-slate-200 focus:border-[#de2169] focus:ring-[#de2169] transition duration-200 text-slate-800 placeholder-slate-400"
                                                placeholder="Masukkan judul permintaan"
                                            >
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-slate-700">
                                            Kota / Wilayah
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <input
                                                type="text"
                                                name="city"
                                                value="{{ $cart['city'] ?? '' }}"
                                                required
                                                class="w-full pl-11 rounded-2xl border-slate-200 focus:border-[#de2169] focus:ring-[#de2169] transition duration-200 text-slate-800 placeholder-slate-400"
                                                placeholder="Masukkan kota layanan"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-slate-700">
                                        Alamat Lengkap
                                    </label>
                                    <textarea
                                        name="address"
                                        rows="3"
                                        required
                                        placeholder="Tuliskan alamat lengkap beserta patokan rumah Anda..."
                                        class="w-full rounded-2xl border-slate-200 focus:border-[#de2169] focus:ring-[#de2169] transition duration-200 text-slate-800 placeholder-slate-400"
                                    ></textarea>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-slate-700">
                                        Catatan Tambahan (Opsional)
                                    </label>
                                    <textarea
                                        name="notes"
                                        rows="2"
                                        placeholder="Contoh: Titip kunci di satpam, masuk gang sebelah masjid..."
                                        class="w-full rounded-2xl border-slate-200 focus:border-[#de2169] focus:ring-[#de2169] transition duration-200 text-slate-800 placeholder-slate-400"
                                    ></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Summary & Actions -->
                <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24">
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Ringkasan Pembayaran</h3>
                            <p class="text-slate-400 text-xs mt-1">Rincian estimasi biaya pengerjaan jasa</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between text-sm text-slate-600">
                                <span>Estimasi Biaya</span>
                                <span class="font-semibold text-slate-800">Rp {{ number_format($cart['estimated_total'] - ($cart['property_surcharge'] ?? 0), 0, ',', '.') }}</span>
                            </div>

                            @if(($cart['property_surcharge'] ?? 0) > 0)
                                <div class="flex justify-between text-sm text-slate-600">
                                    <span>Tambahan Apartemen</span>
                                    <span class="font-semibold text-slate-800">Rp {{ number_format($cart['property_surcharge'], 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <div class="border-t border-slate-100 pt-4 flex justify-between items-center">
                                <span class="font-bold text-slate-900">Total Estimasi</span>
                                <span class="text-2xl font-black text-[#de2169]">
                                    Rp {{ number_format($cart['estimated_total'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- User Balance Info -->
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-slate-500 text-xs">
                                    <svg class="w-4 h-4 text-[#de2169]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span>Saldo Anda</span>
                                </div>
                                @if($user->balance >= $cart['estimated_total'])
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md border border-emerald-100 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Cukup
                                    </span>
                                @else
                                    <span class="bg-rose-50 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded-md border border-rose-100 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Kurang
                                    </span>
                                @endif
                            </div>
                            <p class="text-2xl font-black text-slate-900">
                                Rp {{ number_format($user->balance, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Checkout Actions -->
                        <div class="space-y-3">
                            <!-- Main Checkout Button -->
                            <button
                                type="submit"
                                form="checkout-form"
                                class="w-full bg-[#de2169] hover:bg-[#c21958] text-white font-bold py-3.5 px-6 rounded-2xl transition-all duration-200 shadow-md hover:shadow-lg focus:ring-4 focus:ring-pink-100 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Konfirmasi & Buat Permintaan
                            </button>

                            <!-- Top Up Button / Form -->
                            <form action="{{ route('wallet.topup') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full py-3 px-6 rounded-2xl border-2 border-slate-200 text-slate-700 font-bold hover:bg-slate-50 hover:border-slate-300 transition duration-200 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    + Top Up Saldo Dummy
                                </button>
                            </form>
                        </div>

                        <!-- Note/Info -->
                        <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-start gap-2.5">
                            <div class="text-amber-500 mt-0.5 shrink-0">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] text-amber-800 leading-relaxed font-medium">
                                Harga final akan ditentukan setelah vendor memberikan penawaran. Saldo hanya akan dipotong setelah Anda menerima penawaran tersebut.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
