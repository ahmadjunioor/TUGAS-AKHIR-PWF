<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">

        {{-- Pencarian jasa --}}
        @include('partials.service-search', ['action' => route('dashboard'), 'compact' => true])

        {{-- Kategori Populer --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800 text-center">
                        Kategori Populer
                    </h3>

                    <span class="text-xs text-slate-400">
                        {{ $subcategories->count() }} layanan
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-6 justify-items-center">

                    @foreach($subcategories->take(8) as $sub)

                        <a href="{{ route('booking.show', ['subcategory_id' => $sub->id]) }}"
                        class="flex flex-col items-center text-center group">

                            <div class="w-16 h-16 rounded-2xl bg-pink-50
                                        flex items-center justify-center
                                        text-[#de2169]
                                        shadow-sm
                                        group-hover:bg-[#de2169]
                                        group-hover:text-white
                                        group-hover:scale-110
                                        transition-all duration-300">

                                @php
                                    $name = strtolower($sub->name);
                                @endphp

                                {{-- AC --}}
                                @if(str_contains($name, 'ac'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 8h16M6 12h12M8 16h8"/>
                                    </svg>

                                {{-- Mesin Cuci --}}
                                @elseif(str_contains($name, 'mesin'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="5" y="3" width="14" height="18" rx="2" stroke-width="1.5"/>
                                        <circle cx="12" cy="13" r="4" stroke-width="1.5"/>
                                    </svg>

                                {{-- Kulkas --}}
                                @elseif(str_contains($name, 'kulkas'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="7" y="3" width="10" height="18" rx="2" stroke-width="1.5"/>
                                        <line x1="7" y1="11" x2="17" y2="11" stroke-width="1.5"/>
                                    </svg>

                                {{-- Cleaning --}}
                                @elseif(str_contains($name, 'clean'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 3l8 8M8 11l-3 8m11-8l3 8"/>
                                    </svg>

                                {{-- Renovasi / Kontraktor --}}
                                @elseif(str_contains($name, 'renovasi') || str_contains($name, 'kontraktor'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            d="M14 7l3-3 3 3-9 9H8v-3z"/>
                                    </svg>

                                {{-- Sofa --}}
                                @elseif(str_contains($name, 'sofa'))
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 11h16v6H4z"/>
                                        <path stroke-width="1.5" d="M6 11V8a2 2 0 012-2h2a2 2 0 012 2v3"/>
                                        <path stroke-width="1.5" d="M12 11V8a2 2 0 012-2h2a2 2 0 012 2v3"/>
                                    </svg>

                                {{-- Default --}}
                                @else
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                @endif

                            </div>

                            <span class="mt-3 text-xs font-semibold text-slate-700 leading-tight group-hover:text-[#de2169] transition">
                                {{ $sub->name }}
                            </span>

                        </a>

                    @endforeach

                </div>
            </div>


            {{-- Saldo --}}
                <div class="mt-6 mb-6">
            <div class="bg-gradient-to-r from-pink-200 to-cyan-200
                        rounded-2xl p-6 shadow-lg">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                    <div>
                        <p class="text-slate-600 text-sm font-medium">
                            Saldo Virtual
                        </p>

                        <h2 class="text-4xl font-bold text-slate-900 mt-1">
                            Rp {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}
                        </h2>
                    </div>

                    <form action="{{ route('wallet.topup') }}" method="POST">
                        @csrf

                        <button
                            class="bg-[#de2169] text-white
                                px-6 py-3 rounded-xl
                                font-bold hover:bg-[#c21958] transition">
                            + Top Up Rp 1.000.000
                        </button>
                    </form>

                </div>
            </div>
        </div>
            {{-- Pesanan --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/80">
                    <h2 class="font-bold text-slate-900">Permintaan Jasa Anda</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $requests->count() }} pesanan</p>
                </div>

                @if($requests->isEmpty())
                    <div class="p-10 text-center">
                        <p class="text-slate-500 text-sm mb-1">Belum ada permintaan.</p>
                        <p class="text-xs text-slate-400">Gunakan form di atas untuk pesan jasa.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                        @foreach($requests as $req)
                            <div class="p-5">
                                <div class="flex justify-between items-start gap-3 mb-2">
                                    <h3 class="font-bold text-slate-800 text-sm">{{ $req->title }}</h3>
                                    <span class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-bold
                                        @if($req->status == 'open') bg-blue-100 text-blue-700
                                        @elseif($req->status == 'bidding_closed') bg-violet-100 text-violet-700
                                        @elseif($req->status == 'assigned') bg-amber-100 text-amber-700
                                        @elseif($req->status == 'in_progress') bg-orange-100 text-orange-700
                                        @elseif($req->status == 'awaiting_confirmation') bg-yellow-100 text-yellow-800
                                        @elseif($req->status == 'completed') bg-emerald-100 text-emerald-700
                                        @elseif($req->status == 'disputed') bg-red-100 text-red-700
                                        @else bg-slate-100 text-slate-700 @endif">
                                        {{ $req->statusLabel() }}
                                    </span>
                                </div>
                                @if($req->estimated_total)
                                    <p class="text-xs text-[#de2169] font-semibold mb-2">Estimasi Rp {{ number_format($req->estimated_total, 0, ',', '.') }}</p>
                                @endif
                                <p class="text-xs text-slate-500 mb-3">{{ $req->city }} · {{ $req->created_at->diffForHumans() }}</p>

                                @if($req->quotations->count() > 0)
                                    <div class="bg-slate-50 rounded-lg p-3 space-y-2">
                                        <p class="text-xs font-bold text-slate-700">Penawaran ({{ $req->quotations->count() }})</p>
                                        @foreach($req->quotations as $quote)
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white p-2.5 rounded border border-slate-100">
                                                <div>
                                                    <span class="text-sm font-bold">Rp {{ number_format($quote->amount, 0, ',', '.') }}</span>
                                                    <span class="text-xs text-slate-500 block">{{ $quote->vendorProfile->business_name ?? 'Vendor' }}</span>
                                                </div>
                                                @if(in_array($req->status, ['open', 'bidding_closed']) && $quote->status == 'pending')
                                                    <form action="{{ route('quotations.accept', $quote->id) }}" method="POST" data-confirm="Terima & bayar via saldo?">
                                                        @csrf
                                                        <button class="text-xs font-bold bg-[#de2169] text-white px-3 py-1.5 rounded-lg">Terima</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($req->status === 'awaiting_confirmation')
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <form action="{{ route('requests.confirm', $req->id) }}" method="POST">
                                            @csrf
                                            <button class="text-xs font-bold bg-emerald-600 text-white px-3 py-1.5 rounded-lg">Konfirmasi Selesai</button>
                                        </form>
                                        <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'report-dispute-{{ $req->id }}')" class="text-xs font-bold text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50">Lapor Masalah</button>
                                    </div>
                                @elseif(in_array($req->status, ['assigned', 'in_progress']))
                                    <div class="mt-2">
                                        <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'report-dispute-{{ $req->id }}')" class="text-xs font-bold text-red-600 underline">Lapor Sengketa</button>
                                    </div>
                                @endif

                                @if(in_array($req->status, ['assigned', 'in_progress', 'awaiting_confirmation']))
                                    <x-modal name="report-dispute-{{ $req->id }}" focusable>
                                        <form action="{{ route('requests.dispute', $req->id) }}" method="POST" enctype="multipart/form-data" class="p-6 text-slate-800 text-left">
                                            @csrf
                                            <h2 class="text-lg font-bold text-slate-900 mb-2">Lapor Masalah Jasa</h2>
                                            <p class="text-xs text-slate-500 mb-4">Silakan jelaskan masalah yang Anda alami dengan pengerjaan jasa oleh vendor ini.</p>

                                            <div class="mb-4">
                                                <label for="dispute_notes_{{ $req->id }}" class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Masalah*</label>
                                                <textarea id="dispute_notes_{{ $req->id }}" name="dispute_notes" rows="4" required class="w-full text-sm border-slate-200 focus:ring-[#de2169] focus:border-[#de2169] rounded-lg resize-none placeholder-slate-400" placeholder="Tuliskan keluhan atau masalah pengerjaan secara rinci..."></textarea>
                                            </div>

                                            <div class="mb-6">
                                                <label for="dispute_photo_{{ $req->id }}" class="block text-xs font-bold text-slate-700 uppercase mb-1">Bukti Foto*</label>
                                                <input id="dispute_photo_{{ $req->id }}" name="dispute_photo" type="file" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
                                                <p class="text-[10px] text-slate-400 mt-1">Upload bukti pengerjaan berupa file foto (JPG, JPEG, PNG, max 4MB).</p>
                                            </div>

                                            <div class="flex justify-end gap-3 mt-4">
                                                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50">Batal</button>
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition-colors">Kirim Laporan</button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
