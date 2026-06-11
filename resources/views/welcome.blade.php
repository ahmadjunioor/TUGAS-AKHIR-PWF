<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BantuApaAja — Solusi Jasa Rumah Tangga & Harian Terpercaya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #fdf6f9 0%, #f0f7f7 100%);
        }
        .text-gradient {
            background: linear-gradient(90deg, #b91372 0%, #de2169 50%, #2d9fa3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">
    @include('layouts.navigation')

    <main class="flex-1">
        <!-- Hero Section -->
        <section class="hero-gradient border-b border-slate-200/60 py-20 lg:py-28">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center space-y-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-50 border border-pink-100 rounded-full text-xs font-bold text-[#de2169] uppercase tracking-wider">
                    ⚡ Marketplace Jasa Terpercaya
                </span>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight max-w-4xl mx-auto">
                    Kebutuhan Jasa Rumah Tangga? <br>
                    <span class="text-gradient">BantuApaAja Solusinya!</span>
                </h1>
                
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Mulai dari servis AC, kebersihan rumah, pertukangan, hingga perbaikan elektronik. Temukan mitra terverifikasi dengan sistem pembayaran escrow yang 100% aman.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4 max-w-xl mx-auto w-full">
                    <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center font-bold text-white bg-[#de2169] hover:bg-[#c21958] px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                        Cari Jasa Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('register') }}?as=mitra" class="w-full sm:w-auto inline-flex items-center justify-center font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 px-8 py-4 rounded-2xl shadow-sm hover:shadow transition-all hover:scale-[1.02]">
                        Gabung Sebagai Mitra
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <h2 class="text-3xl font-extrabold text-slate-900">Mengapa Memilih BantuApaAja?</h2>
                    <p class="text-slate-500">Kami berkomitmen memberikan pengalaman pemesanan jasa yang transparan, aman, dan berkualitas.</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <!-- Feature 1 -->
                    <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:border-transparent transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center text-[#de2169]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Pembayaran Escrow Aman</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Dana pembayaran Anda akan ditahan sementara oleh sistem (escrow) dan baru akan dicairkan ke vendor setelah Anda mengonfirmasi pekerjaan selesai dengan baik.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:border-transparent transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center text-[#2d9fa3]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Mitra Terverifikasi</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Setiap penyedia jasa (vendor) melalui proses verifikasi data usaha, keahlian, dan alamat yang ketat oleh tim admin kami untuk menjamin kualitas terbaik.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-8 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-xl hover:border-transparent transition-all duration-300 space-y-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-[#8b1a6b]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Harga Terstandarisasi</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Tidak ada biaya siluman. Rincian harga transparan berdasarkan keluhan dan paket layanan yang Anda pilih pada form pemesanan interaktif kami.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats / Trust Section -->
        <section class="py-16 bg-slate-900 text-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center max-w-5xl mx-auto">
                    <div>
                        <p class="text-4xl font-extrabold text-[#de2169]">100%</p>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1 uppercase tracking-wider font-semibold">Escrow Aman</p>
                    </div>
                    <div>
                        <p class="text-4xl font-extrabold text-white">24/7</p>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1 uppercase tracking-wider font-semibold">Dukungan Sengketa</p>
                    </div>
                    <div>
                        <p class="text-4xl font-extrabold text-[#2d9fa3]">Mitra</p>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1 uppercase tracking-wider font-semibold">Profesional & Ahli</p>
                    </div>
                    <div>
                        <p class="text-4xl font-extrabold text-white">Rp 0</p>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1 uppercase tracking-wider font-semibold">Biaya Tambahan Tersembunyi</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-slate-200 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center space-y-4">
            <p class="font-extrabold text-lg text-slate-900">
                Bantu<span class="text-[#de2169]">ApaAja</span>
            </p>
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} BantuApaAja — Platform Marketplace Jasa Rumah Tangga & Harian Terpercaya.
            </p>
        </div>
    </footer>
</body>
</html>
