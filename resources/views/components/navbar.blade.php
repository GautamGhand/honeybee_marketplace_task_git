{{-- Navbar Component --}}
<nav class="sticky top-0 z-40 bg-gray-900/80 backdrop-blur-xl border-b border-gray-800/50" id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group" id="logo-link">
                <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:shadow-amber-500/40 transition-shadow">
                    <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-amber-400 to-amber-200 bg-clip-text text-transparent">
                    HoneyBee<span class="text-gray-400 font-normal">Market</span>
                </span>
            </a>

            {{-- Search Bar (Desktop) --}}
            <form action="{{ route('listings.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-8" id="search-form">
                <div class="relative w-full group">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Search for products, services..."
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl pl-11 pr-4 py-2.5 text-sm text-gray-200 placeholder-gray-500 focus:outline-none focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/20 transition-all"
                           id="search-input">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('listings.mine') }}" class="hidden sm:flex items-center gap-1.5 text-sm text-gray-400 hover:text-amber-400 transition-colors" id="my-listings-link">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        My Ads
                    </a>
                    <a href="{{ route('listings.create') }}"
                       class="hidden sm:flex items-center gap-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-900 font-semibold text-sm px-4 py-2 rounded-xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all active:scale-95"
                       id="post-ad-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Post Ad
                    </a>
                    <div class="relative hidden sm:block group" id="user-menu">
                        <button class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-200 transition-colors px-2 py-1" id="user-menu-btn">
                            <div class="w-8 h-8 bg-gradient-to-br from-amber-400/20 to-amber-600/20 border border-amber-500/30 rounded-full flex items-center justify-center">
                                <span class="text-amber-400 font-semibold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute right-0 top-full mt-1 w-48 bg-gray-800 border border-gray-700/50 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1" id="user-dropdown">
                            <div class="px-4 py-2 border-b border-gray-700/50">
                                <p class="text-sm font-medium text-gray-200">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('listings.mine') }}" class="block px-4 py-2 text-sm text-gray-400 hover:text-amber-400 hover:bg-gray-700/50 transition-colors">My Listings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-400 hover:text-red-400 hover:bg-gray-700/50 transition-colors" id="logout-btn">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-sm text-gray-400 hover:text-gray-200 transition-colors font-medium" id="login-link">Login</a>
                    <a href="{{ route('register') }}" class="hidden sm:block text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700/50 text-gray-200 px-4 py-2 rounded-xl transition-all" id="register-link">Register</a>
                    <a href="{{ route('login') }}"
                       class="hidden sm:flex items-center gap-1.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-900 font-semibold text-sm px-4 py-2 rounded-xl shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transition-all active:scale-95"
                       id="post-ad-cta">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Post Ad
                    </a>
                @endauth

                {{-- Mobile Menu Toggle --}}
                <button class="md:hidden text-gray-400 hover:text-gray-200 transition-colors" id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Search & Menu --}}
        <div class="hidden md:hidden pb-4" id="mobile-menu">
            <form action="{{ route('listings.index') }}" method="GET" class="mb-3">
                <input type="text" name="q" placeholder="Search..." class="w-full bg-gray-800/50 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200 placeholder-gray-500 focus:outline-none focus:border-amber-500/50">
            </form>
            <div class="space-y-1">
                <a href="{{ route('listings.index') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-amber-400 rounded-lg hover:bg-gray-800/50">Browse Listings</a>
                @auth
                    <a href="{{ route('listings.mine') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-amber-400 rounded-lg hover:bg-gray-800/50">My Listings</a>
                    <a href="{{ route('listings.create') }}" class="block px-3 py-2 text-sm text-amber-400 font-medium rounded-lg hover:bg-gray-800/50">+ Post Ad</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-3 py-2 text-left text-sm text-gray-400 hover:bg-gray-800/50 hover:text-red-400 rounded-lg">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-amber-400 rounded-lg hover:bg-gray-800/50">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-amber-400 rounded-lg hover:bg-gray-800/50">Register</a>
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-sm font-medium text-amber-400 rounded-lg hover:bg-gray-800/50">+ Post Ad</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
