<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chef Dashboard - Restaurantly</title>
    
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
                            dark: '#0c0a09',
                            card: '#1c1917',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(12, 10, 9, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0c0a09; }
        ::-webkit-scrollbar-thumb { background: #44403c; border-radius: 10px; }
        
        /* Notification pulse */
        @keyframes ping-slow {
            75%, 100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        .animate-ping-slow {
            animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
    </style>
</head>
<body class="bg-brand-dark text-gray-200 antialiased" x-data="{ sidebarOpen: false, newOrderAlert: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="w-64 lg:w-72 bg-brand-card border-r border-white/5 flex flex-col fixed inset-y-0 z-50 lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 lg:p-8 flex items-center justify-between">
                <div>
                    <h2 class="text-xl lg:text-2xl font-serif font-black text-orange-500 italic tracking-tighter uppercase">Kitchen</h2>
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mt-1 font-bold">Chef Panel</p>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <nav class="flex-1 px-4 lg:px-6 py-4 space-y-1 overflow-y-auto">
                @php
                    $navItems = [
                        ['Dashboard', 'chef.dashboard', 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['Orders', 'chef.orders', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                        ['Menu', 'chef.menu', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['Tables', 'chef.tables', 'M4 6h16M4 12h16m-7 6h7'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item[1]) }}" 
                       class="flex items-center gap-3 lg:gap-4 px-3 lg:px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs($item[1]) ? 'bg-orange-500 text-white font-bold' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs($item[1]) ? 'text-white' : 'text-gray-400 group-hover:text-orange-500' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item[2] }}"></path>
                        </svg>
                        <span class="text-sm uppercase tracking-widest">{{ $item[0] }}</span>
                        @if($item[0] === 'Orders')
                            @php $pendingCount = \App\Models\InvoiceFood::where('status', '1')->count(); @endphp
                            @if($pendingCount > 0)
                                <span class="ml-auto bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </nav>

            <!-- Chef Profile -->
            <div class="p-4 lg:p-6 mt-auto border-t border-white/5">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name ?? 'C', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ Auth::user()->name ?? 'Chef' }}</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Kitchen Staff</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-red-400/80 hover:text-red-400 hover:bg-red-400/5 rounded-xl transition-all group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="text-sm font-bold uppercase tracking-widest">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 min-h-screen">
            <!-- Top Header -->
            <header class="h-16 lg:h-20 glass flex items-center px-4 lg:px-10 sticky top-0 z-30">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="lg:hidden mr-4 text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex-1">
                    <h1 class="text-base lg:text-lg font-bold text-white uppercase tracking-[0.15em] lg:tracking-[0.2em]">@yield('header', 'Kitchen')</h1>
                </div>
                
                <div class="flex items-center gap-3 lg:gap-6">
                    <!-- New Order Notification Bell -->
                    <div class="relative">
                        @php $newOrders = \App\Models\InvoiceFood::where('status', '1')->count(); @endphp
                        <button class="relative p-2 rounded-full hover:bg-white/5 transition-colors">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($newOrders > 0)
                                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-[10px] font-bold text-white">
                                    {{ $newOrders }}
                                </span>
                                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full animate-ping-slow"></span>
                            @endif
                        </button>
                    </div>

                    <div class="hidden sm:block h-8 w-[1px] bg-white/10"></div>
                    
                    <!-- Current Time -->
                    <div class="hidden sm:flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-wider" x-data x-text="new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})"></span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('message'))
                <div class="mx-4 lg:mx-10 mt-4 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <div class="p-4 lg:p-10">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Auto-refresh for orders page -->
    @if(request()->routeIs('chef.orders') || request()->routeIs('chef.dashboard'))
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(() => location.reload(), 30000);
    </script>
    @endif
</body>
</html>
