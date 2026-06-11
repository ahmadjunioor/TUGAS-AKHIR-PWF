<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Dokumen Persyaratan Vendor') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui dokumen persyaratan usaha Anda. Setelah dokumen diperbarui, profil vendor Anda akan ditinjau kembali oleh admin.') }}
        </p>
    </header>

    @php
        $validation = $user->vendorProfile?->validation;
    @endphp

    <form method="post" action="{{ route('profile.vendor-documents.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        {{-- KTP --}}
        <div>
            <x-input-label for="ktp" :value="__('Foto/Scan KTP')" />
            @if ($validation && $validation->ktp_path)
                <div class="mt-1 mb-2 flex items-center gap-3">
                    <a href="{{ asset('storage/' . $validation->ktp_path) }}" target="_blank" class="text-xs font-bold text-[#de2169] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat KTP Saat Ini
                    </a>
                </div>
            @endif
            <input id="ktp" name="ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
            <x-input-error class="mt-2" :messages="$errors->get('ktp')" />
        </div>

        {{-- Selfie KTP --}}
        <div>
            <x-input-label for="selfie_ktp" :value="__('Foto Diri Bersama KTP')" />
            @if ($validation && $validation->selfie_ktp_path)
                <div class="mt-1 mb-2 flex items-center gap-3">
                    <a href="{{ asset('storage/' . $validation->selfie_ktp_path) }}" target="_blank" class="text-xs font-bold text-[#de2169] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Foto Selfie Saat Ini
                    </a>
                </div>
            @endif
            <input id="selfie_ktp" name="selfie_ktp" type="file" accept=".jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
            <x-input-error class="mt-2" :messages="$errors->get('selfie_ktp')" />
        </div>

        {{-- SKCK --}}
        <div>
            <x-input-label for="skck" :value="__('Surat Keterangan Catatan Kepolisian (SKCK)')" />
            @if ($validation && $validation->skck_path)
                <div class="mt-1 mb-2 flex items-center gap-3">
                    <a href="{{ asset('storage/' . $validation->skck_path) }}" target="_blank" class="text-xs font-bold text-[#de2169] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat SKCK Saat Ini
                    </a>
                </div>
            @endif
            <input id="skck" name="skck" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
            <x-input-error class="mt-2" :messages="$errors->get('skck')" />
        </div>

        {{-- Domisili --}}
        <div>
            <x-input-label for="domicile" :value="__('Surat Keterangan Domisili')" />
            @if ($validation && $validation->domicile_path)
                <div class="mt-1 mb-2 flex items-center gap-3">
                    <a href="{{ asset('storage/' . $validation->domicile_path) }}" target="_blank" class="text-xs font-bold text-[#de2169] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Surat Domisili Saat Ini
                    </a>
                </div>
            @endif
            <input id="domicile" name="domicile" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
            <x-input-error class="mt-2" :messages="$errors->get('domicile')" />
        </div>

        {{-- Kartu Keluarga (KK) --}}
        <div>
            <x-input-label for="kk" :value="__('Kartu Keluarga (KK)')" />
            @if ($validation && $validation->kk_path)
                <div class="mt-1 mb-2 flex items-center gap-3">
                    <a href="{{ asset('storage/' . $validation->kk_path) }}" target="_blank" class="text-xs font-bold text-[#de2169] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat KK Saat Ini
                    </a>
                </div>
            @endif
            <input id="kk" name="kk" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-[#de2169] hover:file:bg-pink-100" />
            <x-input-error class="mt-2" :messages="$errors->get('kk')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Dokumen') }}</x-primary-button>
        </div>
    </form>
</section>
