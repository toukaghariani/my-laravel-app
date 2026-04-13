<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'WolfNet — Stream movies and series.')">

    <title>@yield('title', config('app.name', 'WolfNet'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="font-sans antialiased bg-surface-900 text-gray-100 min-h-screen flex flex-col">

    {{-- ═══════════════════ NAVIGATION ═══════════════════ --}}
    <nav x-data="{ open: false, searchOpen: false }"
         x-init="window.addEventListener('scroll', () => { $el.classList.toggle('nav-scrolled', window.scrollY > 40) })"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300
                bg-gradient-to-b from-black/80 to-transparent"
         id="main-nav">

        <style>
            .nav-scrolled { background: rgba(10,10,10,0.95) !important; backdrop-filter: blur(12px); box-shadow: 0 1px 0 rgba(255,255,255,0.05); }
        </style>

        <div class="max-w-screen-2xl mx-auto px-4 md:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo + Links --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-brand font-extrabold text-2xl tracking-tight" id="nav-logo">
                        WOLFNET
                    </a>

                    <div class="hidden md:flex items-center gap-6">
                        <a href="{{ route('home') }}"
                           class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}"
                           id="nav-home">Home</a>
                        <a href="{{ route('content.index') }}"
                           class="text-sm font-medium transition-colors {{ request()->routeIs('content.index') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}"
                           id="nav-browse">Browse</a>
                        @auth
                            <a href="{{ route('watchlist.index') }}"
                               class="text-sm font-medium transition-colors {{ request()->routeIs('watchlist.index') ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}"
                               id="nav-mylist">My List</a>
                        @endauth
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">
                    {{-- Search --}}
                    <button @click="searchOpen = !searchOpen" class="p-2 text-gray-400 hover:text-white transition-colors" id="nav-search-toggle">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>

                    @auth
                        {{-- User Menu --}}
                        <div x-data="{ userMenu: false }" class="relative">
                            <button @click="userMenu = !userMenu" class="flex items-center gap-2 group" id="nav-user-menu">
                                <div class="w-8 h-8 rounded bg-gradient-to-br from-brand to-red-700 flex items-center justify-center text-white font-bold text-sm ring-1 ring-white/20 group-hover:ring-white/40 transition-all">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <svg class="w-3 h-3 text-gray-400 transition-transform" :class="userMenu && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div x-show="userMenu" @click.away="userMenu = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-52 glass py-2 shadow-2xl"
                                 style="display: none;">
                                <div class="px-4 py-2 border-b border-white/10">
                                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">Profile</a>
                                <a href="{{ route('watchhistory.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">Watch History</a>
                                <a href="{{ route('watchlist.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">My List</a>
                                <a href="{{ route('subscriptions.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">Subscription</a>
                                <a href="{{ route('payments.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-colors">Payments</a>
                                @if(Auth::user()->isAdmin())
                                    <div class="border-t border-white/10 my-1"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-yellow-400 hover:text-yellow-300 hover:bg-white/5 transition-colors">
                                        <span class="mr-1">⚙</span> Admin Panel
                                    </a>
                                @endif
                                <div class="border-t border-white/10 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 transition-colors">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors hidden md:block" id="nav-signin">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm !rounded-full" id="nav-signup">Sign Up</a>
                    @endauth

                    {{-- Mobile hamburger --}}
                    <button @click="open = !open" class="md:hidden p-2 text-gray-400 hover:text-white" id="nav-mobile-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Search Expand --}}
            <div x-show="searchOpen" x-transition x-cloak class="pb-4">
                <form action="{{ route('content.index') }}" method="GET" class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" placeholder="Search titles, genres..."
                           class="input-dark !pl-10 !bg-surface-800" autofocus id="nav-search-input">
                </form>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div x-show="open" x-transition class="md:hidden bg-surface-900/95 backdrop-blur-md border-t border-white/5">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="block py-2.5 px-3 rounded-md text-gray-300 hover:text-white hover:bg-white/5">Home</a>
                <a href="{{ route('content.index') }}" class="block py-2.5 px-3 rounded-md text-gray-300 hover:text-white hover:bg-white/5">Browse</a>
                @auth
                    <a href="{{ route('watchlist.index') }}" class="block py-2.5 px-3 rounded-md text-gray-300 hover:text-white hover:bg-white/5">My List</a>
                @endauth
                <a href="{{ route('subscriptions.plans') }}" class="block py-2.5 px-3 rounded-md text-gray-300 hover:text-white hover:bg-white/5">Plans</a>
                @guest
                    <a href="{{ route('login') }}" class="block py-2.5 px-3 rounded-md text-gray-300 hover:text-white hover:bg-white/5">Sign In</a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- ═══════════════════ FLASH MESSAGES ═══════════════════ --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div class="fixed top-20 right-4 z-[60] space-y-2 max-w-sm"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8">
            @if(session('success'))
                <div class="glass !border-green-500/30 text-green-300 px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="glass !border-red-500/30 text-red-300 px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="glass !border-yellow-500/30 text-yellow-300 px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 2l10 18H2L12 2z"/></svg>
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('info'))
                <div class="glass !border-blue-500/30 text-blue-300 px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/></svg>
                    {{ session('info') }}
                </div>
            @endif
        </div>
    @endif

    {{-- ═══════════════════ MAIN CONTENT ═══════════════════ --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ═══════════════════ FOOTER ═══════════════════ --}}
    <footer class="bg-surface-800/50 border-t border-surface-600/50 mt-auto">
        <div class="max-w-screen-2xl mx-auto px-4 md:px-12 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="text-brand font-extrabold text-xl">WOLFNET</a>
                    <p class="text-gray-500 text-sm mt-3 leading-relaxed">Your premium streaming destination. Watch movies and series anytime, anywhere.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-widest">Navigate</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-gray-300 transition-colors">Home</a></li>
                        <li><a href="{{ route('content.index') }}" class="hover:text-gray-300 transition-colors">Browse</a></li>
                        <li><a href="{{ route('subscriptions.plans') }}" class="hover:text-gray-300 transition-colors">Plans & Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-widest">Account</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        @auth
                            <li><a href="{{ route('user.profile') }}" class="hover:text-gray-300 transition-colors">Profile</a></li>
                            <li><a href="{{ route('watchlist.index') }}" class="hover:text-gray-300 transition-colors">My List</a></li>
                            <li><a href="{{ route('subscriptions.index') }}" class="hover:text-gray-300 transition-colors">Subscription</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-gray-300 transition-colors">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-gray-300 transition-colors">Create Account</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-xs uppercase tracking-widest">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-300 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-gray-300 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-surface-600/50 mt-10 pt-8 text-center text-xs text-gray-600">
                &copy; {{ date('Y') }} WolfNet. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
