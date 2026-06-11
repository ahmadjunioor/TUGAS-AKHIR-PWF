{{-- Form pencarian jasa (dropdown kategori + lokasi) --}}
@props(['action', 'compact' => false])

<section class="{{ $compact ? 'rounded-xl' : 'rounded-2xl' }} sejasa-gradient text-white {{ $compact ? 'p-5 md:p-6' : 'p-8 md:p-10' }}">
    @if (! $compact)
        <h1 class="text-xl md:text-2xl font-bold text-center mb-6 leading-snug">
            Temukan penyedia jasa terpercaya untuk kebutuhan Anda
        </h1>
    @else
        <h2 class="text-lg font-bold mb-4">Pesan Jasa Baru</h2>
    @endif

    <form action="{{ $action }}" method="GET" class="bg-white rounded-lg shadow-lg p-2 flex flex-col md:flex-row gap-2 md:gap-0">
        <div class="flex-1 flex items-center border-b md:border-b-0 md:border-r border-slate-200 px-3 py-2 min-h-[52px]">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <div class="ml-2 flex-1 text-left min-w-0">
                <label class="text-[10px] font-bold text-slate-400 uppercase">Jasa</label>
                <select name="subcategory_id" required class="w-full text-slate-800 font-semibold text-sm border-0 p-0 focus:ring-0 bg-transparent cursor-pointer truncate">
                    <option value="">Pilih layanan...</option>
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->subcategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex-1 flex items-center px-3 py-2 min-h-[52px] relative">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            <div class="ml-2 flex-1 text-left min-w-0 relative" x-data="{
                open: false,
                search: '',
                selected: '{{ session('booking_city', 'Indonesia') }}',
                cities: @js($cities),
                get filteredCities() {
                    if (!this.search) return this.cities;
                    const query = this.search.toLowerCase();
                    return this.cities.filter(c => c.toLowerCase().includes(query));
                },
                selectCity(city) {
                    this.selected = city;
                    this.open = false;
                    this.search = '';
                }
            }" @click.away="open = false" x-init="$watch('open', value => { if(value) { $nextTick(() => { $refs.searchInput.focus(); }); } })">
                <label class="text-[10px] font-bold text-slate-400 uppercase block select-none">Lokasi</label>
                
                <input type="hidden" name="city" :value="selected">
                
                <button type="button" @click="open = !open" class="w-full text-slate-800 font-semibold text-sm cursor-pointer flex justify-between items-center select-none py-0.5 focus:outline-none">
                    <span x-text="selected" class="truncate"></span>
                    <svg class="w-4 h-4 text-slate-400 ml-1 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute z-[200] left-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden"
                     style="display: none;"
                     @keydown.escape.window="open = false">
                    
                    <div class="p-2 border-b border-slate-100 bg-slate-50">
                        <div class="relative flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" 
                                   x-model="search" 
                                   placeholder="Cari kota/daerah..." 
                                   class="w-full pl-8 pr-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:ring-[#de2169] focus:border-[#de2169] text-slate-700 bg-white placeholder-slate-400"
                                   x-ref="searchInput">
                        </div>
                    </div>

                    <ul class="max-h-60 overflow-y-auto divide-y divide-slate-50">
                        <template x-for="city in filteredCities" :key="city">
                            <li>
                                <button type="button" 
                                        @click="selectCity(city)"
                                        class="w-full text-left px-4 py-2.5 text-xs text-slate-700 hover:bg-pink-50 hover:text-[#de2169] font-medium transition-colors flex items-center justify-between"
                                        :class="{'bg-pink-50 text-[#de2169] font-bold': selected === city}">
                                    <span x-text="city"></span>
                                    <svg x-show="selected === city" class="w-3.5 h-3.5 text-[#de2169]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </li>
                        </template>
                        <li x-show="filteredCities.length === 0" class="px-4 py-3 text-xs text-slate-400 text-center italic">
                            Kota tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button type="submit" class="bg-[#de2169] hover:bg-[#c21958] text-white font-bold px-6 py-3 rounded-md transition-colors whitespace-nowrap text-sm">
            Temukan Jasa
        </button>
    </form>
</section>

<style>
    .sejasa-gradient { background: linear-gradient(90deg, #b91372 0%, #8b1a6b 40%, #2d9fa3 100%); }
</style>
