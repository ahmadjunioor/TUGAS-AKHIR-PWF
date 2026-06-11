<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BantuApaAja') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @if(session('success'))
            <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 text-sm text-center py-2 px-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-b border-red-200 text-red-800 text-sm text-center py-2 px-4">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="bg-blue-50 border-b border-blue-200 text-blue-800 text-sm text-center py-2 px-4">{{ session('info') }}</div>
        @endif

        @isset($header)
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-6xl mx-auto py-4 px-4 sm:px-6">{{ $header }}</div>
            </header>
        @endisset

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intercept form submissions with data-confirm attribute
            document.body.addEventListener('submit', function(e) {
                const form = e.target;
                if (form && form.hasAttribute('data-confirm')) {
                    e.preventDefault();
                    const message = form.getAttribute('data-confirm');
                    Swal.fire({
                        title: 'Konfirmasi Tindakan',
                        text: message,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#de2169',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.removeAttribute('data-confirm');
                            form.submit();
                        }
                    });
                }
            });

            // Intercept clicks on elements with data-confirm-click attribute
            document.body.addEventListener('click', function(e) {
                let target = e.target;
                while (target && target !== document.body) {
                    if (target.hasAttribute('data-confirm-click')) {
                        e.preventDefault();
                        const message = target.getAttribute('data-confirm-click');
                        Swal.fire({
                            title: 'Konfirmasi Tindakan',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#de2169',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: 'Ya, Lanjutkan!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (target.tagName === 'A') {
                                    window.location.href = target.href;
                                } else if (target.type === 'submit') {
                                    const form = target.closest('form');
                                    if (form) {
                                        form.submit();
                                    }
                                } else {
                                    const originalConfirm = target.getAttribute('data-confirm-click');
                                    target.removeAttribute('data-confirm-click');
                                    target.click();
                                    target.setAttribute('data-confirm-click', originalConfirm);
                                }
                            }
                        });
                        break;
                    }
                    target = target.parentNode;
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
