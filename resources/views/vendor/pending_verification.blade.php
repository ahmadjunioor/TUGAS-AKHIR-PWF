<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menunggu Verifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8 text-center">
                
                @if($vendorProfile->status == 'pending')
                    <div class="w-24 h-24 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Profil Anda Sedang Direview</h3>
                    <p class="text-gray-500 mb-6">Tim kami sedang melakukan pengecekan terhadap dokumen dan profil bisnis Anda. Mohon tunggu maksimal 2x24 jam kerja.</p>
                @elseif($vendorProfile->status == 'rejected')
                    <div class="w-24 h-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Ditolak</h3>
                    <p class="text-gray-500 mb-6">Mohon maaf, profil Anda ditolak oleh Admin. Silakan periksa kembali kelengkapan dokumen Anda.</p>
                    <a href="{{ route('vendor.register') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">Kirim Ulang Dokumen</a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
