<x-guest-layout>
    <div class="flex flex-col items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white overflow-hidden sm:rounded-xl shadow-sm border border-slate-200">
            <div class="text-center mb-6">
                <a href="/" class="text-2xl font-extrabold text-slate-800">
                    Bantu<span class="text-[#de2169]">ApaAja</span>
                </a>
            </div>

            {{-- Pilih tipe akun --}}
            <div class="grid grid-cols-2 gap-2 mb-6 p-1 bg-slate-100 rounded-lg" id="account-type-tabs">
                <button type="button" data-type="customer"
                    class="account-tab py-2.5 text-sm font-bold rounded-md transition-colors {{ !$asMitra ? 'bg-white text-[#de2169] shadow-sm' : 'text-slate-500' }}">
                    Pelanggan
                </button>
                <button type="button" data-type="vendor"
                    class="account-tab py-2.5 text-sm font-bold rounded-md transition-colors {{ $asMitra ? 'bg-white text-[#de2169] shadow-sm' : 'text-slate-500' }}">
                    Mitra / Vendor
                </button>
            </div>

            <p id="mitra-hint" class="text-xs text-center text-slate-500 mb-4 {{ $asMitra ? '' : 'hidden' }}">
                Setelah daftar, Anda akan mengisi profil usaha & dokumen verifikasi.
            </p>

            <p class="text-center text-sm text-slate-500 mb-6">
                Sudah punya akun?
                <a href="{{ route('login', $asMitra ? ['as' => 'mitra'] : []) }}" class="text-[#de2169] font-semibold hover:underline">Masuk</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="account_type" id="account_type" value="{{ $asMitra ? 'vendor' : 'customer' }}">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-[#de2169] focus:ring-[#de2169]/20">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-[#de2169] focus:ring-[#de2169]/20">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-[#de2169] focus:ring-[#de2169]/20">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    <p class="text-xs text-slate-400 mt-1">Minimal 8 karakter</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:border-[#de2169] focus:ring-[#de2169]/20">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <button type="submit" id="submit-btn"
                    class="w-full bg-[#de2169] hover:bg-[#c21958] text-white font-bold py-2.5 rounded-lg text-sm transition-colors">
                    {{ $asMitra ? 'Daftar & Lanjut Profil Mitra' : 'Daftar sebagai Pelanggan' }}
                </button>

                <p class="text-center text-[11px] text-slate-400 mt-4">
                    Dengan mendaftar, Anda menyetujui syarat & ketentuan platform.
                </p>
            </form>

            <p class="text-center text-xs text-slate-500 mt-6 pt-4 border-t border-slate-100">
                Ingin menerima pekerjaan?
                <a href="{{ route('welcome') }}" class="text-[#de2169] font-semibold">Pelajari program mitra</a>
            </p>
        </div>
    </div>

    <script>
        document.querySelectorAll('.account-tab').forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.dataset.type;
                document.getElementById('account_type').value = type;
                document.querySelectorAll('.account-tab').forEach(b => {
                    b.classList.remove('bg-white', 'text-[#de2169]', 'shadow-sm');
                    b.classList.add('text-slate-500');
                });
                this.classList.add('bg-white', 'text-[#de2169]', 'shadow-sm');
                this.classList.remove('text-slate-500');
                document.getElementById('mitra-hint').classList.toggle('hidden', type !== 'vendor');
                document.getElementById('submit-btn').textContent = type === 'vendor'
                    ? 'Daftar & Lanjut Profil Mitra'
                    : 'Daftar sebagai Pelanggan';
            });
        });
    </script>
</x-guest-layout>
