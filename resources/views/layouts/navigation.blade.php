<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="font-extrabold text-xl text-slate-900 shrink-0 tracking-tight transition-transform hover:scale-[1.02]">
                    Bantu<span class="text-[#de2169] transition-colors duration-300 hover:text-[#c21958]">ApaAja</span>
                </a>
                @auth
                    <div class="hidden sm:flex gap-6 text-sm">
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="font-semibold text-slate-600 hover:text-[#de2169] pb-1 border-b-2 {{ request()->routeIs('admin.*') ? 'text-[#de2169] border-[#de2169]' : 'border-transparent' }} transition-all">Admin Dashboard</a>
                        @elseif(auth()->user()->isVendor())
                            <a href="{{ route('vendor.dashboard') }}" class="font-semibold text-slate-600 hover:text-[#de2169] pb-1 border-b-2 {{ request()->routeIs('vendor.*') ? 'text-[#de2169] border-[#de2169]' : 'border-transparent' }} transition-all">Vendor Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="font-semibold text-slate-600 hover:text-[#de2169] pb-1 border-b-2 {{ request()->routeIs('dashboard') ? 'text-[#de2169] border-[#de2169]' : 'border-transparent' }} transition-all">Beranda</a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="hidden sm:flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-[#de2169] transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-[#de2169] hover:bg-[#c21958] px-5 py-2 rounded-xl transition-all shadow-sm hover:shadow-md">Daftar</a>
                @else
                    @if(!auth()->user()->isSuperAdmin())
                        {{-- Balance Widget --}}
                        <div class="flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 shadow-sm transition-all hover:bg-slate-100">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-slate-500 font-medium">Saldo:</span>
                            <span class="text-slate-900">Rp {{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                        
                        @if(!auth()->user()->isVendor())
                            <a href="{{ route('vendor.register') }}" class="inline-flex items-center text-xs font-bold text-[#de2169] border border-[#de2169] px-4 py-2 rounded-xl hover:bg-pink-50 transition-all">Jadi Vendor</a>
                        @endif
                    @endif
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-[#de2169] bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 transition-all">
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-slate-500 border-b border-slate-100">
                                Peran: <span class="font-bold text-slate-700 capitalize">{{ Auth::user()->role }}</span>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil Saya
                            </x-dropdown-link>
                            @if(auth()->user()->isVendor() && !auth()->user()->vendorProfile)
                                <x-dropdown-link :href="route('vendor.register')">
                                    Lengkapi Profil Vendor
                                </x-dropdown-link>
                            @endif
                            <div class="border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-red-700">
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            <div class="sm:hidden flex items-center gap-2">
                @auth
                    @if(!auth()->user()->isSuperAdmin())
                        <div class="text-xs font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5">
                            Rp {{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}
                        </div>
                    @endif
                @endauth
                <button @click="open = !open" class="p-2 text-slate-500 hover:bg-slate-50 rounded-lg transition-colors focus:outline-none">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-3 shadow-inner">
        @auth
            <div class="pb-2 border-b border-slate-100">
                <p class="text-xs text-slate-400">Masuk sebagai</p>
                <p class="font-bold text-slate-800 text-sm">{{ Auth::user()->name }}</p>
            </div>
            
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block text-sm font-semibold text-slate-700 hover:text-[#de2169] py-1 transition-colors">Admin Dashboard</a>
            @elseif(auth()->user()->isVendor())
                <a href="{{ route('vendor.dashboard') }}" class="block text-sm font-semibold text-slate-700 hover:text-[#de2169] py-1 transition-colors">Vendor Dashboard</a>
            @else
                <a href="{{ route('dashboard') }}" class="block text-sm font-semibold text-slate-700 hover:text-[#de2169] py-1 transition-colors">Beranda</a>
            @endif

            @if(!auth()->user()->isVendor() && !auth()->user()->isSuperAdmin())
                <a href="{{ route('vendor.register') }}" class="block text-sm font-semibold text-[#de2169] py-1 transition-colors">Jadi Vendor</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold text-slate-700 hover:text-[#de2169] py-1 transition-colors">Profil Saya</a>
            
            <div class="border-t border-slate-100 my-2 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm font-semibold text-red-600 hover:text-red-700 py-1 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="block text-sm font-semibold text-slate-700 hover:text-[#de2169] py-2 transition-colors">Masuk</a>
            <a href="{{ route('register') }}" class="block text-center text-sm font-bold text-white bg-[#de2169] hover:bg-[#c21958] py-2 rounded-xl transition-all shadow-sm">Daftar</a>
        @endauth
    </div>
</nav>
