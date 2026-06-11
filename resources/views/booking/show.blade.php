<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 pb-28">
    <nav class="text-xs text-slate-500 mb-4">
        <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="hover:text-[#de2169]">Beranda</a>
        <span class="mx-1">/</span>
        <span class="text-slate-800 font-medium">{{ $subcategory->name }}</span>
    </nav>

    <h1 class="text-2xl font-bold text-slate-900 mb-2">{{ $subcategory->name }}</h1>
    <p class="text-sm text-slate-500 mb-6">{{ $subcategory->category->name }} · Lokasi: {{ $cart['city'] ?? 'Indonesia' }}</p>

    <ul class="text-sm text-slate-600 space-y-1 mb-8">
        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Harga terstandarisasi</li>
        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Penyedia Jasa Terverifikasi</li>
        <li class="flex items-center gap-2"><span class="text-emerald-500">✓</span> Pembayaran aman (escrow)</li>
    </ul>

    <form action="{{ route('booking.update') }}" method="POST" id="booking-form">
        @csrf
        <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">

        {{-- Keluhan --}}
        <section class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
            <h2 class="font-bold text-slate-900 mb-1">Keluhan / masalah</h2>
            <p class="text-xs text-slate-500 mb-4">Pilih yang sesuai kebutuhan {{ $subcategory->name }} Anda</p>
            <div class="space-y-3">
                @foreach($complaints as $complaint)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="complaints[]" value="{{ $complaint }}"
                            @checked(in_array($complaint, $cart['complaints'] ?? []))
                            class="rounded border-slate-300 text-[#de2169] focus:ring-[#de2169]">
                        <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-[#de2169]">{{ $complaint }}</span>
                    </label>
                @endforeach
            </div>
        </section>

        {{-- Paket layanan --}}
        <section class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
            <h2 class="font-bold text-slate-900 mb-4">Layanan yang Anda Butuhkan</h2>
            @forelse($subcategory->packages as $package)
                @php
                    $inCart = collect($cart['items'] ?? [])->firstWhere('package_id', $package->id);
                    $qty = $inCart['qty'] ?? 0;
                @endphp
                <div class="flex gap-4 py-4 border-b border-slate-100 last:border-0">
                    <div class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                        <svg class="w-8 h-8 text-[#46A7B3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-slate-800">{{ $package->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $package->description }}</p>
                        <p class="text-sm font-bold text-[#de2169] mt-1">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <input type="number" name="packages[{{ $package->id }}]" value="{{ $qty }}" min="0" max="10"
                            class="w-14 text-center border border-slate-200 rounded-lg text-sm py-1 package-qty"
                            data-price="{{ $package->price }}">
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500 py-4 text-center">Memuat paket layanan...</p>
            @endforelse
        </section>

        {{-- Tipe properti --}}
        <section class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
            <h2 class="font-bold text-slate-900 mb-4">Jenis properti Anda?</h2>
            <div class="space-y-3">
                @foreach($propertyTypes as $key => $type)
                    <label class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="property_type" value="{{ $key }}"
                                @checked(($cart['property_type'] ?? 'rumah') === $key)
                                data-surcharge="{{ $type['surcharge'] }}"
                                class="text-[#de2169] focus:ring-[#de2169] property-radio">
                            <span class="text-sm font-medium property-label @if(($cart['property_type'] ?? 'rumah') === $key) text-[#de2169] @endif">{{ $type['label'] }}</span>
                        </div>
                        @if($type['surcharge'] > 0)
                            <span class="text-xs text-slate-500">+Rp {{ number_format($type['surcharge'], 0, ',', '.') }}</span>
                        @endif
                    </label>
                @endforeach
            </div>
        </section>

        {{-- Jadwal --}}
        <section class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
            <h2 class="font-bold text-slate-900 mb-4">Kapan Anda membutuhkan layanan?</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Tanggal</label>
                    <input type="date" name="scheduled_date" value="{{ $cart['scheduled_date'] ?? now()->addDay()->format('Y-m-d') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase">Pukul</label>
                    <input type="time" name="scheduled_time" value="{{ $cart['scheduled_time'] ?? '08:00' }}"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>
        </section>
    </form>
</div>

{{-- Sticky footer --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-lg z-40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
        <div>
            <p class="text-xs text-slate-500 font-medium">Estimasi Harga</p>
            <p class="text-2xl font-bold text-[#de2169]" id="estimated-display">Rp {{ number_format($estimatedTotal ?? 0, 0, ',', '.') }}</p>
        </div>
        <button type="submit" form="booking-form" name="action" value="checkout"
            class="bg-[#de2169] hover:bg-[#c21958] text-white font-bold px-8 py-3 rounded-lg transition-colors">
            Selanjutnya
        </button>
    </div>
</div>

<script>
(function() {
    const fmt = n => 'Rp ' + n.toLocaleString('id-ID');
    const propertyRadios = document.querySelectorAll('.property-radio');
    const qtyInputs = document.querySelectorAll('.package-qty');
    const display = document.getElementById('estimated-display');
    if (!display) return;
    function calc() {
        let sub = 0;
        qtyInputs.forEach(inp => { sub += (parseInt(inp.value) || 0) * parseFloat(inp.dataset.price || 0); });
        let surcharge = 0;
        propertyRadios.forEach(r => { if (r.checked) surcharge = parseFloat(r.dataset.surcharge || 0); });
        display.textContent = fmt(sub + surcharge);
    }
    qtyInputs.forEach(i => i.addEventListener('input', calc));
    propertyRadios.forEach(r => {
        r.addEventListener('change', () => {
            document.querySelectorAll('.property-label').forEach(l => l.classList.remove('text-[#de2169]'));
            r.closest('label')?.querySelector('.property-label')?.classList.add('text-[#de2169]');
            calc();
        });
    });
})();
</script>
</x-app-layout>
