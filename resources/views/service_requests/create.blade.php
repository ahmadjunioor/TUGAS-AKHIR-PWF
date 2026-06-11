<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Outfit', sans-serif; background-color: #F8FAFC; }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center text-slate-500 hover:text-indigo-600 font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl shadow-indigo-500/10 rounded-[2rem] border border-slate-100">
                <div class="relative bg-gradient-to-r from-indigo-900 to-purple-800 p-10 text-white overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
                    
                    <div class="relative z-10">
                        <div class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold tracking-widest uppercase mb-4 border border-white/30">
                            Langkah 1 dari 1
                        </div>
                        <h2 class="text-4xl font-extrabold mb-3">Apa yang Anda butuhkan?</h2>
                        <p class="text-indigo-200 text-lg font-medium max-w-xl">Beritahu kami masalah Anda dengan detail, agar Mitra Vendor kami dapat memberikan penawaran harga yang paling akurat.</p>
                    </div>
                </div>

                <form action="{{ route('requests.store') }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Permintaan <span class="text-pink-500">*</span></label>
                        <input type="text" name="title" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium" placeholder="Contoh: Perbaikan AC Split Bocor 1 PK" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Jasa <span class="text-pink-500">*</span></label>
                            <select id="category-select" name="category_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Sub Kategori <span class="text-pink-500">*</span></label>
                            <select id="subcategory-select" name="subcategory_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium" required disabled>
                                <option value="" disabled selected>Pilih sub kategori...</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kota / Lokasi <span class="text-pink-500">*</span></label>
                            <input type="text" name="city" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium" placeholder="Contoh: Jakarta Selatan" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Budget Maksimal (Opsional)</label>
                            <input type="number" name="max_budget" min="0" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium" placeholder="Contoh: 500000">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap <span class="text-pink-500">*</span></label>
                        <textarea name="address" rows="2" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium resize-none" placeholder="Tuliskan alamat lengkap lokasi pengerjaan (Jl. Mawar No.12, RT/RW...)" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Detail <span class="text-pink-500">*</span></label>
                        <textarea name="description" rows="5" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium resize-none" placeholder="Ceritakan sedetail mungkin: apa merknya? sudah berapa lama rusak? apakah butuh material tambahan?" required></textarea>
                        <p class="text-xs font-semibold text-slate-400 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Deskripsi yang jelas membantu vendor memberikan estimasi harga yang tepat.
                        </p>
                    </div>

                    <div class="pt-8 flex justify-end">
                        <button type="submit" class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-extrabold text-lg rounded-full shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto">
                            Kirim Permintaan Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('category-select').addEventListener('change', function() {
            const subSelect = document.getElementById('subcategory-select');
            subSelect.innerHTML = '<option value="" disabled selected>Memuat...</option>';
            subSelect.disabled = true;

            if (!this.value) return;

            fetch('/api/categories/' + this.value + '/subcategories')
                .then(r => r.json())
                .then(data => {
                    subSelect.innerHTML = '<option value="" disabled selected>Pilih sub kategori...</option>';
                    data.forEach(item => {
                        subSelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                    subSelect.disabled = false;
                });
        });
    </script>
</x-app-layout>
