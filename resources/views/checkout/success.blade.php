<x-app-layout>
<div class="max-w-lg mx-auto px-4 sm:px-6 py-12 text-center">
    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="text-xl font-bold text-slate-900 mb-2">Pesanan Berhasil!</h1>
    <p class="text-sm text-slate-500 mb-1">{{ $request->title }}</p>
    @if($request->estimated_total)
        <p class="text-sm text-[#de2169] font-semibold mb-6">Estimasi Rp {{ number_format($request->estimated_total, 0, ',', '.') }}</p>
    @endif
    <p class="text-xs text-slate-500 mb-8">Vendor akan memberikan penawaran. Cek status di beranda Anda.</p>
    <a href="{{ route('dashboard') }}" class="inline-block bg-[#de2169] text-white font-bold px-6 py-2.5 rounded-lg text-sm">Kembali ke Beranda</a>
</div>
</x-app-layout>
