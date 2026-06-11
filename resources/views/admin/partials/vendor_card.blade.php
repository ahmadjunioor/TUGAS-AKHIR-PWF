<div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-8" x-data="{ expanded: false }">
    <div class="flex flex-col md:flex-row gap-6 items-start justify-between">
        
        <!-- Vendor info header -->
        <div class="flex items-center gap-4 flex-1">
            <img class="w-16 h-16 rounded-2xl object-cover bg-slate-100 border border-slate-100 shadow-inner shrink-0" 
                 src="{{ $vendor->logo_path ? asset('storage/' . $vendor->logo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($vendor->business_name) . '&background=de2169&color=fff&bold=true&size=128' }}" 
                 alt="{{ $vendor->business_name }}">
            
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-xl font-bold text-slate-900">{{ $vendor->business_name }}</h4>
                    
                    @if($type === 'pending')
                        <span class="bg-amber-50 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-lg border border-amber-100">Menunggu Verifikasi</span>
                    @elseif($type === 'approved')
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-lg border border-emerald-100">Aktif / Disetujui</span>
                    @elseif($type === 'rejected')
                        <span class="bg-rose-50 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded-lg border border-rose-100">Ditolak</span>
                    @endif
                </div>
                
                <p class="text-xs text-slate-500">
                    Kategori: <span class="font-semibold text-slate-700">{{ $vendor->category->name ?? '-' }}</span> / {{ $vendor->subcategory->name ?? '-' }}
                </p>
                <p class="text-xs text-slate-400">
                    Terdaftar: {{ $vendor->created_at->format('d M Y, H:i') }} WIB
                </p>
            </div>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2 shrink-0 w-full md:w-auto pt-4 md:pt-0 border-t border-slate-100 md:border-t-0">
            <!-- Expand toggle button -->
            <button 
                @click="expanded = !expanded" 
                class="flex-1 md:flex-none py-2 px-4 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold rounded-xl transition duration-200 text-sm flex items-center justify-center gap-2 border border-slate-200">
                <svg class="w-4 h-4 text-slate-500 transition-transform duration-200" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                Detail & Dokumen
            </button>

            <!-- Direct action buttons -->
            @if($type === 'pending' || $type === 'rejected')
                <form action="{{ route('admin.vendor.approve', $vendor->id) }}" method="POST" class="flex-1 md:flex-none">
                    @csrf
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl transition-all duration-200 text-sm flex items-center justify-center gap-1 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui
                    </button>
                </form>
            @endif

            @if($type === 'pending' || $type === 'approved')
                <form action="{{ route('admin.vendor.reject', $vendor->id) }}" method="POST" class="flex-1 md:flex-none">
                    @csrf
                    <button class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-xl transition-all duration-200 text-sm flex items-center justify-center gap-1 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tolak
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Expanded Details -->
    <div x-show="expanded" x-collapse class="mt-6 pt-6 border-t border-slate-100" style="display: none;">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Vendor profile info -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-4">
                <div>
                    <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Deskripsi Bisnis</h5>
                    <p class="text-slate-700 text-sm mt-1.5 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        {{ $vendor->description ?: 'Tidak ada deskripsi bisnis.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Kontak Bisnis</h5>
                        <ul class="text-sm text-slate-700 mt-2 space-y-2">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#de2169]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21.05 8m-5 10H5a2 2 0 01-2-2V8a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2z"></path></svg>
                                <span>{{ $vendor->business_email ?: $vendor->user->email }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#de2169]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $vendor->phone_number }}</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Alamat Lengkap</h5>
                        <p class="text-sm text-slate-700 mt-2 leading-relaxed">
                            {{ $vendor->full_address }},<br>
                            Kel. {{ $vendor->sub_district_name }}, Kec. {{ $vendor->district_name }},<br>
                            {{ $vendor->city_name }}, Prov. {{ $vendor->province_name }}
                        </p>
                    </div>
                </div>

                <div>
                    <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Pemilik Akun</h5>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">
                            {{ substr($vendor->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $vendor->user->name }}</p>
                            <p class="text-xs text-slate-500">User ID: {{ $vendor->user_id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uploaded documents for verification -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-4">
                <h5 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Dokumen Verifikasi Resmi</h5>
                
                @if($vendor->validation)
                    <div class="grid grid-cols-1 gap-2.5">
                        
                        <!-- KTP -->
                        <a href="{{ asset('storage/' . $vendor->validation->ktp_path) }}" target="_blank" 
                           class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-pink-50 hover:border-pink-200 transition-all text-slate-700 hover:text-[#de2169] group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-200/50 group-hover:bg-pink-100/50 text-slate-600 group-hover:text-[#de2169] flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.378 0 2.5-1.122 2.5-2.5S10.378 9 9 9m5 8v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2"></path>
                                    </svg>
                                </div>
                                <div class="pr-2">
                                    <p class="text-xs font-bold">Kartu Tanda Penduduk (KTP)</p>
                                    <p class="text-[10px] text-slate-400">Klik untuk melihat file</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#de2169] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        <!-- Selfie + KTP -->
                        <a href="{{ asset('storage/' . $vendor->validation->selfie_ktp_path) }}" target="_blank" 
                           class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-pink-50 hover:border-pink-200 transition-all text-slate-700 hover:text-[#de2169] group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-200/50 group-hover:bg-pink-100/50 text-slate-600 group-hover:text-[#de2169] flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="pr-2">
                                    <p class="text-xs font-bold">Foto Selfie + KTP</p>
                                    <p class="text-[10px] text-slate-400">Klik untuk melihat file</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#de2169] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        <!-- SKCK -->
                        <a href="{{ asset('storage/' . $vendor->validation->skck_path) }}" target="_blank" 
                           class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-pink-50 hover:border-pink-200 transition-all text-slate-700 hover:text-[#de2169] group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-200/50 group-hover:bg-pink-100/50 text-slate-600 group-hover:text-[#de2169] flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="pr-2">
                                    <p class="text-xs font-bold">Surat SKCK</p>
                                    <p class="text-[10px] text-slate-400">Klik untuk melihat file</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#de2169] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        <!-- Domicile (Optional) -->
                        @if($vendor->validation->domicile_path)
                            <a href="{{ asset('storage/' . $vendor->validation->domicile_path) }}" target="_blank" 
                               class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-pink-50 hover:border-pink-200 transition-all text-slate-700 hover:text-[#de2169] group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-200/50 group-hover:bg-pink-100/50 text-slate-600 group-hover:text-[#de2169] flex items-center justify-center transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                    <div class="pr-2">
                                        <p class="text-xs font-bold">Keterangan Domisili</p>
                                        <p class="text-[10px] text-slate-400">Klik untuk melihat file</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#de2169] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        @endif

                        <!-- KK (Optional) -->
                        @if($vendor->validation->kk_path)
                            <a href="{{ asset('storage/' . $vendor->validation->kk_path) }}" target="_blank" 
                               class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl hover:bg-pink-50 hover:border-pink-200 transition-all text-slate-700 hover:text-[#de2169] group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-200/50 group-hover:bg-pink-100/50 text-slate-600 group-hover:text-[#de2169] flex items-center justify-center transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="pr-2">
                                        <p class="text-xs font-bold">Kartu Keluarga (KK)</p>
                                        <p class="text-[10px] text-slate-400">Klik untuk melihat file</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity text-[#de2169] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        @endif

                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Dokumen verifikasi tidak tersedia.</p>
                @endif
            </div>

        </div>
    </div>
</div>
