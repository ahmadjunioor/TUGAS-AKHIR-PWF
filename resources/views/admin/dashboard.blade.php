<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-10" x-data="{ activeTab: 'pending' }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admin Dashboard</h1>
                    <p class="text-slate-500 mt-1">Kelola verifikasi pendaftaran vendor dan selesaikan sengketa transaksi.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-px mb-8">
                <button 
                    @click="activeTab = 'pending'"
                    :class="activeTab === 'pending' ? 'border-[#de2169] text-[#de2169] bg-pink-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="flex items-center gap-2 px-4 py-3 border-b-2 font-bold text-sm transition-all rounded-t-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Menunggu Verifikasi
                    <span :class="activeTab === 'pending' ? 'bg-[#de2169] text-white' : 'bg-slate-100 text-slate-600'" class="text-xs font-bold px-2 py-0.5 rounded-full ml-1">{{ $pendingVendors->count() }}</span>
                </button>
                
                <button 
                    @click="activeTab = 'approved'"
                    :class="activeTab === 'approved' ? 'border-[#de2169] text-[#de2169] bg-pink-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="flex items-center gap-2 px-4 py-3 border-b-2 font-bold text-sm transition-all rounded-t-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Vendor Disetujui
                    <span :class="activeTab === 'approved' ? 'bg-[#de2169] text-white' : 'bg-slate-100 text-slate-600'" class="text-xs font-bold px-2 py-0.5 rounded-full ml-1">{{ $approvedVendors->count() }}</span>
                </button>
                
                <button 
                    @click="activeTab = 'rejected'"
                    :class="activeTab === 'rejected' ? 'border-[#de2169] text-[#de2169] bg-pink-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="flex items-center gap-2 px-4 py-3 border-b-2 font-bold text-sm transition-all rounded-t-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Vendor Ditolak
                    <span :class="activeTab === 'rejected' ? 'bg-[#de2169] text-white' : 'bg-slate-100 text-slate-600'" class="text-xs font-bold px-2 py-0.5 rounded-full ml-1">{{ $rejectedVendors->count() }}</span>
                </button>

                <button 
                    @click="activeTab = 'disputes'"
                    :class="activeTab === 'disputes' ? 'border-[#de2169] text-[#de2169] bg-pink-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                    class="flex items-center gap-2 px-4 py-3 border-b-2 font-bold text-sm transition-all rounded-t-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Tiket Sengketa
                    <span :class="activeTab === 'disputes' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 border border-red-100'" class="text-xs font-bold px-2 py-0.5 rounded-full ml-1">{{ $disputedTasks->count() }}</span>
                </button>
            </div>

            <!-- Tab Content: Pending Vendors -->
            <div x-show="activeTab === 'pending'" class="space-y-6">
                @forelse ($pendingVendors as $vendor)
                    @include('admin.partials.vendor_card', ['vendor' => $vendor, 'type' => 'pending'])
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 text-lg">Semua Bersih!</p>
                        <p class="text-slate-400 text-sm mt-1">Tidak ada vendor yang sedang menunggu persetujuan verifikasi.</p>
                    </div>
                @endforelse
            </div>

            <!-- Tab Content: Approved Vendors -->
            <div x-show="activeTab === 'approved'" class="space-y-6" style="display: none;">
                @forelse ($approvedVendors as $vendor)
                    @include('admin.partials.vendor_card', ['vendor' => $vendor, 'type' => 'approved'])
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 text-lg">Belum Ada Vendor Aktif</p>
                        <p class="text-slate-400 text-sm mt-1">Belum ada pendaftaran vendor yang disetujui.</p>
                    </div>
                @endforelse
            </div>

            <!-- Tab Content: Rejected Vendors -->
            <div x-show="activeTab === 'rejected'" class="space-y-6" style="display: none;">
                @forelse ($rejectedVendors as $vendor)
                    @include('admin.partials.vendor_card', ['vendor' => $vendor, 'type' => 'rejected'])
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 text-lg">Tidak Ada Pendaftaran Ditolak</p>
                        <p class="text-slate-400 text-sm mt-1">Tidak ada pendaftaran vendor yang ditolak atau dinonaktifkan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Tab Content: Disputes -->
            <div x-show="activeTab === 'disputes'" class="space-y-6" style="display: none;">
                @forelse ($disputedTasks as $task)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-8 flex flex-col md:flex-row gap-6 justify-between items-start">
                        <div class="flex-1 space-y-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="bg-red-50 text-red-700 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-red-100">Sengketa Aktif</span>
                                <span class="text-slate-300">|</span>
                                <span class="text-slate-900 font-extrabold text-lg">{{ $task->title }}</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                <div>
                                    <p class="text-slate-400 text-xs">Pelanggan</p>
                                    <p class="font-bold text-slate-700 mt-0.5">{{ $task->customer->name }}</p>
                                    <p class="text-slate-500 text-xs mt-0.5">{{ $task->customer->email }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400 text-xs">Vendor Terpilih</p>
                                    <p class="font-bold text-slate-700 mt-0.5">
                                        {{ $task->quotations->where('status','accepted')->first()->vendorProfile->business_name ?? 'Tidak Diketahui' }}
                                    </p>
                                    <p class="text-slate-500 text-xs mt-0.5">
                                        {{ $task->quotations->where('status','accepted')->first()->vendorProfile->business_email ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <p class="text-slate-800 text-sm font-bold">Rincian & Kronologi</p>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    {{ $task->description }}
                                </p>
                            </div>

                            @if($task->dispute_notes)
                            <div class="space-y-2">
                                <p class="text-red-700 text-sm font-bold">Catatan Masalah Sengketa</p>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-red-50 p-4 rounded-2xl border border-red-100">
                                    {{ $task->dispute_notes }}
                                </p>
                            </div>
                            @endif

                            @if($task->dispute_photo_path)
                            <div class="space-y-2">
                                <p class="text-slate-800 text-sm font-bold">Bukti Foto</p>
                                <div class="max-w-md">
                                    <a href="{{ asset('storage/' . $task->dispute_photo_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $task->dispute_photo_path) }}" alt="Bukti Foto Sengketa" class="rounded-2xl border border-slate-200 max-h-60 object-contain hover:opacity-90 transition">
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-6 items-center text-sm">
                                <div>
                                    <span class="text-slate-400 text-xs">Nilai Transaksi (Escrow)</span>
                                    <p class="text-lg font-black text-[#de2169] mt-0.5">
                                        Rp {{ number_format($task->quotations->where('status','accepted')->first()->amount ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-xs">Jadwal Layanan</span>
                                    <p class="font-semibold text-slate-700 mt-0.5">{{ $task->scheduled_at ? date('d M Y, H:i', strtotime($task->scheduled_at)) . ' WIB' : '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row md:flex-col gap-3 shrink-0 w-full md:w-auto">
                            <form action="{{ route('admin.dispute.resolve', $task->id) }}" method="POST" class="w-full" data-confirm="Refund dana ke Pelanggan? Dana sebesar Rp {{ number_format($task->quotations->where('status', 'accepted')->first()->amount ?? 0, 0, ',', '.') }} akan dikembalikan ke saldo dompet pelanggan.">
                                @csrf
                                <input type="hidden" name="action" value="refund">
                                <button 
                                    class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-5 rounded-2xl transition duration-200 text-sm flex items-center justify-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                                    </svg>
                                    Refund Pelanggan
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.dispute.resolve', $task->id) }}" method="POST" class="w-full" data-confirm="Pencairan dana paksa ke Vendor? Dana sebesar Rp {{ number_format($task->quotations->where('status', 'accepted')->first()->amount ?? 0, 0, ',', '.') }} akan diteruskan ke saldo dompet vendor.">
                                @csrf
                                <input type="hidden" name="action" value="release">
                                <button 
                                    class="w-full bg-[#de2169] hover:bg-[#c21958] text-white font-bold py-3 px-5 rounded-2xl transition duration-200 text-sm flex items-center justify-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Teruskan ke Vendor
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700 text-lg">Tidak Ada Tiket Sengketa</p>
                        <p class="text-slate-400 text-sm mt-1">Semua transaksi berjalan lancar tanpa perselisihan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
