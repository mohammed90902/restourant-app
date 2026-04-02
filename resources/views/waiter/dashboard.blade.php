@extends('waiter')

@section('header', 'Service Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8 lg:mb-12">
    <!-- Ready to Serve -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-green-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-green-500/10 text-green-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            @if($readyToServe > 0)
                <span class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></span>
            @endif
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $readyToServe }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Ready to Serve</p>
    </div>

    <!-- Active Orders -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-blue-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-blue-500/10 text-blue-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $activeOrders }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Active Orders</p>
    </div>

    <!-- Tables -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-emerald-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $tablesOccupied }}/{{ $totalTables }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Tables Occupied</p>
    </div>

    <!-- Today Served -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-purple-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-purple-500/10 text-purple-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $todayServed }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Served Today</p>
    </div>
</div>

<!-- Ready Orders Section -->
<div class="relative">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 lg:mb-8 gap-4">
        <div>
            <span class="text-green-500 font-bold tracking-[0.2em] lg:tracking-[0.3em] uppercase text-[10px] mb-2 block">Ready for Service</span>
            <h3 class="text-xl lg:text-3xl font-serif font-black text-white uppercase tracking-tighter">Pickup Queue</h3>
        </div>
        <a href="{{ route('waiter.orders') }}" class="text-xs font-bold uppercase tracking-widest text-emerald-500 hover:text-white transition-colors flex items-center gap-2">
            View All Orders
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>

    @if($readyOrders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">
            @foreach($readyOrders as $order)
                <div class="group bg-brand-card border border-green-500/30 rounded-2xl p-4 lg:p-6 hover:border-green-500/50 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/10 rounded-full -mr-12 -mt-12 blur-2xl"></div>
                    
                    <div class="flex items-start justify-between mb-4 relative">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400 font-bold border border-green-500/30">
                                #{{ $order->id }}
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Table {{ $order->invoice->table->table_number ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <span class="flex items-center gap-1 text-green-500">
                            <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-[10px] font-bold uppercase">Ready</span>
                        </span>
                    </div>

                    <h4 class="text-lg lg:text-xl font-serif font-bold text-white mb-2 group-hover:text-green-400 transition-colors">
                        {{ $order->food->name_en }}
                    </h4>
                    
                    <div class="flex items-center gap-4 text-gray-400 text-xs mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Qty: {{ $order->quantity }}
                        </span>
                    </div>

                    <!-- Action Button -->
                    <form action="{{ route('waiter.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="4">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark Delivered
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-brand-card border border-white/5 rounded-3xl p-12 lg:p-20 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-xl">All caught up!</p>
            <p class="text-gray-500 text-sm mt-2">No orders ready for pickup</p>
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="mt-8 lg:mt-12 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <a href="{{ route('waiter.take-order') }}" class="flex items-center gap-4 bg-brand-card border border-white/5 rounded-2xl p-6 hover:border-emerald-500/30 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-white group-hover:text-emerald-400 transition-colors">Take New Order</h4>
            <p class="text-gray-400 text-sm">Create order for a table</p>
        </div>
    </a>
    
    <a href="{{ route('waiter.tables') }}" class="flex items-center gap-4 bg-brand-card border border-white/5 rounded-2xl p-6 hover:border-blue-500/30 transition-all group">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-white group-hover:text-blue-400 transition-colors">View Tables</h4>
            <p class="text-gray-400 text-sm">Check table status</p>
        </div>
    </a>
</div>
@endsection
