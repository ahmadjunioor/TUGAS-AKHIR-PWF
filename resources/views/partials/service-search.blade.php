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
        <div class="flex-1 flex items-center px-3 py-2 min-h-[52px]">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            <div class="ml-2 flex-1 text-left min-w-0">
                <label class="text-[10px] font-bold text-slate-400 uppercase">Lokasi</label>
                <select name="city" class="w-full text-slate-800 font-semibold text-sm border-0 p-0 focus:ring-0 bg-transparent cursor-pointer">
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected(session('booking_city', 'Indonesia') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
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
