{{-- Footer Component --}}
<footer class="bg-gray-900/50 border-t border-gray-800/50 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-amber-400">HoneyBee<span class="text-gray-500">Market</span></span>
                </a>
                <p class="text-sm text-gray-500 leading-relaxed">Buy & sell anything near you. India's most trusted marketplace for products and services.</p>
            </div>

            {{-- Popular Categories --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Categories</h4>
                <ul class="space-y-2">
                    @php
                        $footerCategories = ['electronics', 'vehicles', 'property', 'fashion', 'jobs', 'services'];
                    @endphp
                    @foreach($footerCategories as $cat)
                        <li><a href="{{ route('listings.category', $cat) }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">{{ ucfirst($cat) }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('listings.index') }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">Browse Listings</a></li>
                    <li><a href="{{ route('listings.create') }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">Post Ad</a></li>
                    <li><a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-amber-400 transition-colors">Register</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Contact</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        support@honeybee.market
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        India
                    </li>
                </ul>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-amber-500/20 border border-gray-700/50 hover:border-amber-500/50 rounded-lg flex items-center justify-center text-gray-500 hover:text-amber-400 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-amber-500/20 border border-gray-700/50 hover:border-amber-500/50 rounded-lg flex items-center justify-center text-gray-500 hover:text-amber-400 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 hover:bg-amber-500/20 border border-gray-700/50 hover:border-amber-500/50 rounded-lg flex items-center justify-center text-gray-500 hover:text-amber-400 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800/50 mt-8 pt-8 text-center">
            <p class="text-sm text-gray-600">&copy; {{ date('Y') }} HoneyBee Market. All rights reserved.</p>
        </div>
    </div>
</footer>
