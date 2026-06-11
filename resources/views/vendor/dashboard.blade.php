<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Dashboard Vendor</h1>
            <p class="text-sm text-slate-500">{{ $vendorProfile->business_name }}</p>
        </div>

        @if (session('success'))
            <div class="p-3 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-3 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            {{-- Left Column: Active Jobs & New Jobs search --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h2 class="font-bold text-slate-900 text-sm">Pekerjaan Aktif</h2>
                        <span class="text-xs font-bold bg-[#de2169]/10 text-[#de2169] px-2 py-0.5 rounded-full">{{ $myJobs->count() }}</span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($myJobs as $job)
                            <div class="p-5">
                                <div class="flex justify-between items-start gap-3 mb-2">
                                    <h3 class="font-bold text-slate-800 text-sm">{{ $job->title }}</h3>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100">{{ $job->statusLabel() }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mb-3">{{ $job->city }} · {{ $job->customer->name }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($job->status === 'assigned')
                                        <form action="{{ route('requests.start', $job->id) }}" method="POST">@csrf
                                            <button class="text-xs font-bold bg-[#de2169] text-white px-3 py-1.5 rounded-lg">Mulai</button>
                                        </form>
                                    @endif
                                    @if($job->status === 'in_progress')
                                        <form action="{{ route('requests.finish', $job->id) }}" method="POST">@csrf
                                            <button class="text-xs font-bold bg-emerald-600 text-white px-3 py-1.5 rounded-lg">Selesai</button>
                                        </form>
                                    @endif
                                    @if($job->status === 'awaiting_confirmation')
                                        <span class="text-xs text-amber-700">Menunggu konfirmasi pelanggan</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="p-8 text-center text-sm text-slate-500">Belum ada pekerjaan aktif.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h2 class="font-bold text-slate-900 text-sm">Cari Pekerjaan Baru</h2>
                        <span class="text-xs font-bold bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full">{{ $requests->count() }}</span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse ($requests as $req)
                            <div class="p-5 flex flex-col md:flex-row gap-4">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-slate-800 text-sm mb-1">{{ $req->title }}</h3>
                                    <p class="text-xs text-slate-500 mb-2">{{ $req->city }}</p>
                                    <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-lg line-clamp-3">{{ $req->description }}</p>
                                    <p class="text-[10px] text-slate-400 mt-2">Penawaran: {{ $req->quotations_count }}/5</p>
                                </div>
                                <div class="md:w-64 shrink-0 border border-slate-100 rounded-lg p-4">
                                    <form action="{{ route('quotations.store', $req->id) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <input type="number" name="amount" min="1000" placeholder="Harga (Rp)" required
                                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2">
                                        <textarea name="message" rows="2" placeholder="Catatan" class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2 resize-none"></textarea>
                                        <button type="submit" class="w-full bg-[#de2169] text-white text-xs font-bold py-2 rounded-lg">Kirim Penawaran</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="p-8 text-center text-sm text-slate-500">Belum ada permintaan baru.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Column: Vendor profile card --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50">
                        <h2 class="font-bold text-slate-900 text-sm">Profil Usaha Vendor</h2>
                    </div>
                    <div class="p-5 space-y-5">
                        <div class="flex items-center gap-4">
                            <img class="w-16 h-16 rounded-2xl object-cover bg-slate-100 border border-slate-100 shadow-inner shrink-0" 
                                 src="{{ $vendorProfile->logo_path ? asset('storage/' . $vendorProfile->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($vendorProfile->business_name) . '&background=de2169&color=fff&bold=true&size=128' }}" 
                                 alt="{{ $vendorProfile->business_name }}">
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">{{ $vendorProfile->business_name }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $vendorProfile->category->name ?? '-' }} / {{ $vendorProfile->subcategory->name ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi Bisnis</h4>
                            <p class="text-xs text-slate-600 mt-1 leading-relaxed whitespace-pre-line bg-slate-50/50 p-3 rounded-lg border border-slate-100/60">{{ $vendorProfile->description ?: 'Tidak ada deskripsi.' }}</p>
                        </div>

                        <div class="border-t border-slate-100 pt-4 space-y-3">
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kontak Bisnis</h4>
                                <p class="text-xs text-slate-700 mt-1.5 flex items-center gap-2">
                                    <span class="text-slate-400">Email:</span>
                                    <span class="font-medium">{{ $vendorProfile->business_email ?: Auth::user()->email }}</span>
                                </p>
                                <p class="text-xs text-slate-700 mt-1 flex items-center gap-2">
                                    <span class="text-slate-400">No. Telp:</span>
                                    <span class="font-medium">{{ $vendorProfile->phone_number ?: '-' }}</span>
                                </p>
                            </div>

                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Lengkap</h4>
                                <p class="text-xs text-slate-700 mt-1.5 leading-relaxed bg-slate-50/50 p-3 rounded-lg border border-slate-100/60">
                                    {{ $vendorProfile->full_address }},<br>
                                    Kel. {{ $vendorProfile->sub_district_name }}, Kec. {{ $vendorProfile->district_name }},<br>
                                    {{ $vendorProfile->city_name }}, Prov. {{ $vendorProfile->province_name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
