<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BantuApaAja') — Marketplace Jasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sejasa-gradient { background: linear-gradient(90deg, #b91372 0%, #8b1a6b 35%, #2d9fa3 100%); }
        .sejasa-pink { color: #de2169; }
        .bg-sejasa-pink { background-color: #de2169; }
        .border-sejasa-pink { border-color: #de2169; }
        .ring-sejasa-pink:focus { --tw-ring-color: #de2169; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="font-extrabold text-xl text-slate-900 shrink-0">
                Bantu<span class="text-[#de2169]">ApaAja</span>
            </a>

            <form action="{{ route('home') }}" method="GET" class="hidden md:flex flex-1 max-w-md">
                <div class="flex w-full items-center rounded-lg border border-slate-200 bg-slate-50 px-3">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" placeholder="Cari Kategori" class="w-full bg-transparent border-0 text-sm py-2 px-2 focus:ring-0">
                </div>
            </form>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ auth()->check() ? route('vendor.register') : route('login') }}" class="hidden sm:inline text-sm font-semibold text-[#de2169] border border-[#de2169] px-4 py-2 rounded hover:bg-pink-50">
                    Cari Vendor Terbaik!
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-[#de2169]">{{ Auth::user()->name }}</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-[#de2169]">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-[#de2169]">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 text-sm text-center py-2 px-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 text-red-800 text-sm text-center py-2 px-4">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="bg-blue-50 border-b border-blue-200 text-blue-800 text-sm text-center py-2 px-4">{{ session('info') }}</div>
    @endif

    <main>@yield('content')</main>

    <footer class="bg-white border-t border-slate-200 mt-16 py-8 text-center text-sm text-slate-500">
        &copy; {{ date('Y') }} BantuApaAja — Marketplace Jasa Terpercaya
    </footer>

    @stack('scripts')
</body>
</html>
