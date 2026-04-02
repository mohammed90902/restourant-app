<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waiter Dashboard - Restaurantly</title>
    
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
                            dark: '#0f172a',
                            card: '#1e293b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body class="bg-brand-dark text-gray-200 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/60 z-40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="w-64 lg:w-72 bg-brand-card border-r border-white/5 flex flex-col fixed inset-y-0 z-50 lg:translate-x-0 transition-transform duration-300">
            <div class="p-6 lg:p-8 flex items-center justify-between">
                <div>
                    <h2 class="text-xl lg:text-2xl font-serif font-black text-emerald-500 italic tracking-tighter uppercase">Service</h2>
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mt-1 font-bold">Waiter Panel</p>
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
                        ['Dashboard', 'waiter.dashboard', 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                        ['Orders', 'waiter.orders', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                        ['Tables', 'waiter.tables', 'M4 6h16M4 12h16m-7 6h7'],
                        ['Take Order', 'waiter.take-order', 'M12 4v16m8-8H4'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item[1]) }}" 
                       class="flex items-center gap-3 lg:gap-4 px-3 lg:px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs($item[1]) ? 'bg-emerald-500 text-white font-bold' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs($item[1]) ? 'text-white' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item[2] }}"></path>
                        </svg>
                        <span class="text-sm uppercase tracking-widest">{{ $item[0] }}</span>
                        @if($item[0] === 'Orders')
                            @php $readyCount = \App\Models\InvoiceFood::where('status', '3')->count(); @endphp
                            @if($readyCount > 0)
                                <span class="ml-auto bg-green-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                    {{ $readyCount }}
                                </span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </nav>

            <!-- Waiter Profile -->
            <div class="p-4 lg:p-6 mt-auto border-t border-white/5">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name ?? 'W', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ Auth::user()->name ?? 'Waiter' }}</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Service Staff</p>
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
                    <h1 class="text-base lg:text-lg font-bold text-white uppercase tracking-[0.15em] lg:tracking-[0.2em]">@yield('header', 'Service')</h1>
                </div>
                
                <div class="flex items-center gap-3 lg:gap-6">
                    <!-- Ready to Serve Alert -->
                    <div class="relative">
                        @php $readyOrders = \App\Models\InvoiceFood::where('status', '3')->count(); @endphp
                        <a href="{{ route('waiter.orders') }}" class="relative p-2 rounded-full hover:bg-white/5 transition-colors">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 {{ $readyOrders > 0 ? 'text-green-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($readyOrders > 0)
                                <span class="absolute top-0 right-0 h-4 w-4 bg-green-500 rounded-full flex items-center justify-center text-[10px] font-bold text-white animate-pulse">
                                    {{ $readyOrders }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <a href="{{ route('waiter.take-order') }}" class="hidden sm:flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white text-[10px] font-bold py-2 px-4 rounded-full transition-all uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        New Order
                    </a>
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
</body>
</html>
