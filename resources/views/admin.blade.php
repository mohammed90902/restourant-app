<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Restaurantly</title>
    
    <!-- Scripts/CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#f59e0b',
                            dark: '#0f172a', // Slightly lighter Slate 900 for better contrast
                            card: '#1e293b', // Lighter Slate 800 for cards
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-brand-dark text-gray-200 antialiased selection:bg-brand-gold selection:text-black">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-brand-card border-r border-white/5 flex flex-col fixed inset-y-0 z-50">
            <div class="p-8">
                <h2 class="text-2xl font-serif font-black text-brand-gold italic tracking-tighter uppercase">Restaurantly</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em] mt-1 font-bold">Admin Panel</p>
            </div>
            
            <nav class="flex-1 px-6 py-4 space-y-1 overflow-y-auto">
                @php
                    $navItems = [
                        ['Dashboard', 'admin.dashboard', 'M4 6h16M4 12h16M4 18h16'],
                        ['Users', 'users.index', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['Categories', 'categories.index', 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                        ['Sub-Categories', 'sub-categories.index', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                        ['Food Menu', 'foods.index', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['Tables', 'tables.index', 'M4 6h16M4 12h16m-7 6h7'],
                        ['Reservations', 'reservations.index', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['Orders', 'orders.index', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item[1]) }}" 
                       class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs($item[1]) ? 'bg-brand-gold text-black font-bold' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs($item[1]) ? 'text-black' : 'text-gray-400 group-hover:text-brand-gold' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item[2] }}"></path>
                        </svg>
                        <span class="text-sm uppercase tracking-widest">{{ $item[0] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="p-6 mt-auto border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-4 w-full px-4 py-3 text-red-400/80 hover:text-red-400 hover:bg-red-400/5 rounded-xl transition-all group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="text-sm font-bold uppercase tracking-widest">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 min-h-screen">
            <!-- Top Header -->
            <header class="h-20 glass flex items-center px-10 sticky top-0 z-40">
                <div class="flex-1">
                    <h1 class="text-lg font-bold text-white uppercase tracking-[0.2em]">@yield('header', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="{{ route('Frontend.home') }}" class="text-[10px] font-black uppercase tracking-widest text-brand-gold border border-brand-gold/30 px-4 py-2 rounded-full hover:bg-brand-gold hover:text-black transition-all">
                        Live Site
                    </a>
                    <div class="h-8 w-[1px] bg-white/10"></div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-gold flex items-center justify-center text-black font-bold text-xs">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <div class="p-10">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
