<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-white">
        
        <div class="text-center mb-10">
            <h1 class="text-2xl font-bold text-slate-800">Buat Profil Usaha Baru</h1>
        </div>

        <!-- Progress Bar -->
        <div class="relative max-w-2xl mx-auto mb-16">
            <div class="overflow-hidden h-0.5 mb-4 text-xs flex bg-gray-200">
                <div style="width: 10%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#46A7B3]"></div>
            </div>
            <div class="flex justify-between w-full absolute -top-1.5">
                <div class="text-center w-1/3 relative">
                    <div class="w-3 h-3 bg-[#46A7B3] rounded-full mx-auto ring-4 ring-white"></div>
                    <span class="text-[10px] text-[#46A7B3] mt-2 block font-semibold">Detail Profil Bisnis</span>
                </div>
                <div class="text-center w-1/3 relative">
                    <div class="w-3 h-3 bg-gray-300 rounded-full mx-auto ring-4 ring-white"></div>
                    <span class="text-[10px] text-gray-400 mt-2 block">Album / Portfolio Bisnis Anda</span>
                </div>
                <div class="text-center w-1/3 relative">
                    <div class="w-3 h-3 bg-gray-300 rounded-full mx-auto ring-4 ring-white"></div>
                    <span class="text-[10px] text-gray-400 mt-2 block">Informasi Tambahan</span>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data" class="border border-gray-200 p-8 sm:p-12 pb-16 relative">
            @csrf

            <!-- Upload Logo Section -->
            <div class="flex flex-col items-center justify-center mb-12">
                <div id="logo-preview-container" class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 relative overflow-hidden">
                    <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="relative overflow-hidden inline-block border border-[#46A7B3] bg-white text-[#46A7B3] px-6 py-2 cursor-pointer mb-4 hover:bg-gray-50 transition-colors">
                    <span class="text-xs font-semibold">Upload Logo</span>
                    <input type="file" name="logo" class="absolute left-0 top-0 opacity-0 cursor-pointer w-full h-full">
                </div>
                <div class="border border-gray-200 px-6 py-3 text-center max-w-sm">
                    <p class="text-[10px] text-gray-500 font-medium">Upload logo usaha Anda di sini, dalam format file JPG, JPEG, atau PNG Ukuran minimum: 300px</p>
                </div>
            </div>

            <!-- Informasi Utama -->
            <div class="mb-10">
                <h2 class="text-lg font-bold text-slate-800 border-b-2 border-gray-200 pb-2 mb-6">Informasi Utama</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Nama usaha</label>
                        <input type="text" name="business_name" class="w-full border border-[#46A7B3] focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-500 rounded-none shadow-sm" placeholder="Tuliskan nama usaha Anda" required>
                        <p class="text-[10px] text-gray-400 mt-1">Pastikan nama usaha Anda sudah sesuai. Nama usaha hanya dapat diubah ketika pembuatan profil usaha baru.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Deskripsi usaha</label>
                        <textarea name="description" rows="4" class="w-full border border-[#46A7B3] focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-400 rounded-none shadow-sm resize-none" placeholder="Deskripsikan usaha Anda agar Customer Anda memahami lebih detail usaha Anda." required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Kategori jasa</label>
                        <select id="vendor-category" name="category_id" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Sub kategori jasa</label>
                        <select id="vendor-subcategory" name="subcategory_id" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required disabled>
                            <option value="">Pilih sub kategori</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="mb-10">
                <h2 class="text-lg font-bold text-slate-800 border-b-2 border-gray-200 pb-2 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Email</label>
                        <div class="flex items-center gap-2">
                            <input type="email" name="business_email" value="{{ old('business_email', auth()->user()->email) }}" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" placeholder="Email bisnis">
                            <button type="button" class="w-6 h-6 rounded-full bg-[#46A7B3] text-white flex items-center justify-center font-bold pb-0.5">+</button>
                        </div>
                        <div class="mt-2 flex items-center gap-2">
                            <input type="checkbox" class="border-gray-300 text-[#46A7B3] focus:ring-0 rounded-sm w-3 h-3">
                            <span class="text-[10px] text-gray-600 font-bold">Saya tidak ingin menerima notifikasi email setiap kali ada permintaan pekerjaan baru.</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">No handphone</label>
                        <div class="flex items-center gap-2 mb-1">
                            <input type="text" name="phone" class="w-1/2 sm:w-1/3 border border-[#46A7B3] focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-400 rounded-none shadow-sm" placeholder="Nomor Telepon">
                            <button type="button" class="w-6 h-6 rounded-full bg-[#46A7B3] text-white flex items-center justify-center font-bold pb-0.5">+</button>
                        </div>
                        <p class="text-[10px] text-gray-600 font-bold">Anda akan mendapatkan notifikasi SMS di nomor ini</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Provinsi</label>
                        <select name="province" id="province-select" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->code }}">{{ $prov->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Kota / Kabupaten</label>
                        <select name="city" id="city-select" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required disabled>
                            <option value="">Pilih Kota / Kabupaten</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Kecamatan</label>
                        <select name="district" id="district-select" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Kelurahan</label>
                        <select name="sub_district" id="village-select" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-700 rounded-none shadow-sm" required disabled>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1">Alamat lengkap</label>
                        <textarea name="address" rows="2" class="w-full border border-gray-300 focus:ring-0 focus:border-[#46A7B3] p-2 text-sm text-gray-400 rounded-none shadow-sm resize-none" placeholder="Alamat Lengkap" required></textarea>
                    </div>
                </div>
            </div>

            <!-- Validasi Bisnis -->
            <div class="mb-10">
                <h2 class="text-lg font-bold text-slate-800 border-b-2 border-gray-200 pb-2 mb-6">Validasi Bisnis</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <!-- Foto KTP -->
                    <div class="flex flex-col items-center">
                        <div id="ktp-preview-container" class="w-full aspect-square border-2 border-[#46A7B3] flex flex-col items-center justify-center relative cursor-pointer hover:bg-gray-50 transition-colors overflow-hidden">
                            <span class="text-6xl text-[#46A7B3] font-light leading-none placeholder-text">+</span>
                            <input type="file" name="ktp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold mt-2 text-center">Foto/scan KTP*</span>
                    </div>
                    
                    <!-- Foto Diri dgn KTP -->
                    <div class="flex flex-col items-center">
                        <div id="selfie-ktp-preview-container" class="w-full aspect-square border-2 border-[#46A7B3] flex flex-col items-center justify-center relative cursor-pointer hover:bg-gray-50 transition-colors overflow-hidden">
                            <span class="text-6xl text-[#46A7B3] font-light leading-none placeholder-text">+</span>
                            <input type="file" name="selfie_ktp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png" required>
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold mt-2 text-center">Foto diri bersama KTP*</span>
                    </div>

                    <!-- SKCK -->
                    <div class="flex flex-col items-center">
                        <div id="skck-preview-container" class="w-full aspect-square border-2 border-[#46A7B3] flex flex-col items-center justify-center relative cursor-pointer hover:bg-gray-50 transition-colors overflow-hidden">
                            <span class="text-6xl text-[#46A7B3] font-light leading-none placeholder-text">+</span>
                            <input type="file" name="skck" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold mt-2 text-center leading-tight">Surat Keterangan Catatan Kepolisian (SKCK)*</span>
                    </div>

                    <!-- Surat Domisili -->
                    <div class="flex flex-col items-center">
                        <div id="domicile-preview-container" class="w-full aspect-square border-2 border-[#46A7B3] flex flex-col items-center justify-center relative cursor-pointer hover:bg-gray-50 transition-colors overflow-hidden">
                            <span class="text-6xl text-[#46A7B3] font-light leading-none placeholder-text">+</span>
                            <input type="file" name="domicile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold mt-2 text-center leading-tight">Foto/scan surat domisili dari kelurahan**</span>
                    </div>

                    <!-- Foto KK -->
                    <div class="flex flex-col items-center">
                        <div id="kk-preview-container" class="w-full aspect-square border-2 border-[#46A7B3] flex flex-col items-center justify-center relative cursor-pointer hover:bg-gray-50 transition-colors overflow-hidden">
                            <span class="text-6xl text-[#46A7B3] font-light leading-none placeholder-text">+</span>
                            <input type="file" name="kk" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                        <span class="text-[10px] text-gray-700 font-bold mt-2 text-center">Foto KK</span>
                    </div>
                </div>

                <div class="mt-4 space-y-1">
                    <p class="text-[10px] text-[#de2169] font-bold">*Wajib diisi</p>
                    <p class="text-[10px] text-[#de2169] font-bold">**Wajib untuk kategori Servis Peralatan Elektronik, Jasa Rumah Tangga, Perbaikan Rumah & Renovasi, Arsitek & Interior Spesialis</p>
                </div>
            </div>

            <div class="text-center mt-12 mb-4">
                <button type="submit" class="bg-[#de2169] hover:bg-[#c21958] text-white font-bold py-3 px-12 rounded-sm text-sm transition-colors shadow-md">
                    Simpan dan Lanjutkan
                </button>
            </div>
            
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province-select');
            const citySelect = document.getElementById('city-select');
            const districtSelect = document.getElementById('district-select');
            const villageSelect = document.getElementById('village-select');

            provinceSelect.addEventListener('change', function() {
                let provinceCode = this.value;
                citySelect.innerHTML = '<option value="">Pilih Kota / Kabupaten</option>';
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                citySelect.disabled = true;
                districtSelect.disabled = true;
                villageSelect.disabled = true;

                if (provinceCode) {
                    fetch('/api/regions/cities?province_code=' + provinceCode)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.code}">${city.name}</option>`;
                            });
                            citySelect.disabled = false;
                        });
                }
            });

            citySelect.addEventListener('change', function() {
                let cityCode = this.value;
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                districtSelect.disabled = true;
                villageSelect.disabled = true;

                if (cityCode) {
                    fetch('/api/regions/districts?city_code=' + cityCode)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.code}">${district.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        });
                }
            });

            districtSelect.addEventListener('change', function() {
                let districtCode = this.value;
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                villageSelect.disabled = true;

                if (districtCode) {
                    fetch('/api/regions/villages?district_code=' + districtCode)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(village => {
                                villageSelect.innerHTML += `<option value="${village.code}">${village.name}</option>`;
                            });
                            villageSelect.disabled = false;
                        });
                }
            });

            const vendorCategory = document.getElementById('vendor-category');
            const vendorSubcategory = document.getElementById('vendor-subcategory');
            if (vendorCategory) {
                vendorCategory.addEventListener('change', function() {
                    vendorSubcategory.innerHTML = '<option value="">Memuat...</option>';
                    vendorSubcategory.disabled = true;
                    if (!this.value) return;
                    fetch('/api/categories/' + this.value + '/subcategories')
                        .then(r => r.json())
                        .then(data => {
                            vendorSubcategory.innerHTML = '<option value="">Pilih sub kategori</option>';
                            data.forEach(item => {
                                vendorSubcategory.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                            });
                            vendorSubcategory.disabled = false;
                        });
                });
            }

            // File input preview logic
            const setupPreview = (inputSelector, previewContainerSelector) => {
                const input = document.querySelector(`input[name="${inputSelector}"]`);
                const container = document.querySelector(previewContainerSelector);
                if (!input || !container) return;

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Clear any existing preview elements
                            const oldPreview = container.querySelector('.preview-element');
                            if (oldPreview) oldPreview.remove();

                            const svgPlaceholder = container.querySelector('svg');
                            const spanPlaceholder = container.querySelector('.placeholder-text');

                            if (svgPlaceholder) svgPlaceholder.classList.add('hidden');
                            if (spanPlaceholder) spanPlaceholder.classList.add('hidden');

                            if (file.type.startsWith('image/')) {
                                const img = document.createElement('img');
                                img.className = 'preview-element w-full h-full object-cover absolute inset-0';
                                img.src = e.target.result;
                                container.appendChild(img);
                            } else if (file.type === 'application/pdf') {
                                const div = document.createElement('div');
                                div.className = 'preview-element absolute inset-0 flex flex-col items-center justify-center p-4 bg-red-50 text-red-600';
                                div.innerHTML = `
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[9px] font-bold mt-1 uppercase truncate max-w-full">${file.name}</span>
                                `;
                                container.appendChild(div);
                            } else {
                                // Other file types
                                const div = document.createElement('div');
                                div.className = 'preview-element absolute inset-0 flex flex-col items-center justify-center p-4 bg-gray-50 text-gray-500';
                                div.innerHTML = `
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-[9px] font-bold mt-1 uppercase truncate max-w-full">${file.name}</span>
                                `;
                                container.appendChild(div);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            };

            // Setup previews for each file input
            setupPreview('logo', '#logo-preview-container');
            setupPreview('ktp', '#ktp-preview-container');
            setupPreview('selfie_ktp', '#selfie-ktp-preview-container');
            setupPreview('skck', '#skck-preview-container');
            setupPreview('domicile', '#domicile-preview-container');
            setupPreview('kk', '#kk-preview-container');
        });
    </script>
</x-app-layout>
