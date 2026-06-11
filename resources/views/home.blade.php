<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BantuApaAja — Marketplace Jasa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sejasa-gradient { background: linear-gradient(90deg, #b91372 0%, #8b1a6b 40%, #2d9fa3 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">
    @include('layouts.navigation')

    <main class="flex-1 max-w-6xl mx-auto w-full px-4 sm:px-6 py-10 space-y-8">
        @include('partials.service-search', ['action' => route('home'), 'compact' => false])

        <div class="grid sm:grid-cols-3 gap-4 text-center text-sm">
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="w-8 h-8 bg-[#de2169] text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm">1</div>
                <p class="font-semibold">Pilih Jasa</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="w-8 h-8 bg-[#46A7B3] text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm">2</div>
                <p class="font-semibold">Checkout</p>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <div class="w-8 h-8 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm" style="background-color: #8b1a6b;">3</div>
                <p class="font-semibold">Terima Penawaran</p>
            </div>
        </div>

        <p class="text-center text-sm text-slate-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-[#de2169]">Masuk</a> untuk kelola pesanan di satu halaman.
        </p>
    </main>

    <footer class="text-center text-xs text-slate-400 py-6 border-t border-slate-200">
        &copy; {{ date('Y') }} BantuApaAja
    </footer>
</body>
</html>
