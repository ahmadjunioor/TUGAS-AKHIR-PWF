<x-guest-layout>
    <div class="flex flex-col items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white overflow-hidden sm:rounded-lg">
            <div class="text-center mb-8">
                <a href="/" class="text-3xl font-extrabold text-slate-800">
                    Bantu<span class="text-[#de2169]">ApaAja</span>
                </a>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-[#de2169] focus:ring focus:ring-[#de2169] focus:ring-opacity-20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    <p class="text-xs text-gray-400 mt-1">Contoh: nama@email.com</p>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block font-medium text-sm text-gray-700">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-[#de2169] focus:ring focus:ring-[#de2169] focus:ring-opacity-20" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mb-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm font-semibold text-[#de2169] hover:underline" href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                <div class="flex flex-col gap-4">
                    <button type="submit" class="w-full justify-center bg-[#de2169] hover:bg-[#c21958] text-white font-bold py-3 px-4 rounded-md transition-colors text-sm">
                        Masuk
                    </button>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Belum terdaftar?
                        <a href="{{ route('register') }}" class="text-[#de2169] font-semibold hover:underline">Daftar Pelanggan</a>
                        ·
                        <a href="{{ route('register', ['as' => 'mitra']) }}" class="text-[#de2169] font-semibold hover:underline">Daftar Mitra</a>
                    </p>
                    <p class="text-center text-xs text-gray-500 mt-2">
                        Lihat <a href="#" class="text-[#de2169] hover:underline">kebijakan dan privasi</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
