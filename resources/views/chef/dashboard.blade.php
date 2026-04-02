@extends('chef')

@section('header', 'Kitchen Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8 lg:mb-12">
    <!-- Pending Orders -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-orange-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-orange-500/10 text-orange-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            @if($pendingCount > 0)
                <span class="h-2 w-2 bg-orange-500 rounded-full animate-pulse"></span>
            @endif
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $pendingCount }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Pending</p>
    </div>

    <!-- Preparing Orders -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-blue-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-blue-500/10 text-blue-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                </svg>
            </div>
            @if($preparingCount > 0)
                <span class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></span>
            @endif
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $preparingCount }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Cooking</p>
    </div>

    <!-- Ready Orders -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-green-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-green-500/10 text-green-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $readyCount }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Ready</p>
    </div>

    <!-- Today Completed -->
    <div class="group bg-brand-card border border-white/5 rounded-2xl lg:rounded-3xl p-4 lg:p-6 hover:border-purple-500/30 transition-all duration-500">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 rounded-xl bg-purple-500/10 text-purple-500">
                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
        <h3 class="text-2xl lg:text-3xl font-serif font-black text-white">{{ $todayCompleted }}</h3>
        <p class="text-[10px] lg:text-xs text-gray-400 uppercase tracking-widest mt-1">Today Done</p>
    </div>
</div>

<!-- Active Orders Quick View -->
<div class="relative">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 lg:mb-8 gap-4">
        <div>
            <span class="text-orange-500 font-bold tracking-[0.2em] lg:tracking-[0.3em] uppercase text-[10px] mb-2 block">Priority Queue</span>
            <h3 class="text-xl lg:text-3xl font-serif font-black text-white uppercase tracking-tighter">Active Orders</h3>
        </div>
        <a href="{{ route('chef.orders') }}" class="text-xs font-bold uppercase tracking-widest text-orange-500 hover:text-white transition-colors flex items-center gap-2">
            View All Orders
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>

    @if($recentOrders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">
            @foreach($recentOrders as $order)
                @php
                    $waitTime = $order->created_at->diffInMinutes(now());
                    $isDelayed = $waitTime > 15;
                @endphp
                <div class="group bg-brand-card border {{ $isDelayed ? 'border-red-500/50' : 'border-white/5' }} rounded-2xl p-4 lg:p-6 hover:border-orange-500/30 transition-all duration-500 relative overflow-hidden">
                    @if($isDelayed)
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">
                            DELAYED
                        </div>
                    @endif
                    
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 font-bold border border-white/10">
                                #{{ $order->id }}
                            </div>
                            <div>
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-500/10 text-orange-500 text-[10px] font-black uppercase">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Table {{ $order->invoice->table->table_number ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        @if($order->status == '1')
                            <span class="flex items-center gap-1 text-orange-500">
                                <span class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                                <span class="text-[10px] font-bold uppercase">New</span>
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-blue-500">
                                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                <span class="text-[10px] font-bold uppercase">Cooking</span>
                            </span>
                        @endif
                    </div>

                    <h4 class="text-lg lg:text-xl font-serif font-bold text-white mb-2 group-hover:text-orange-500 transition-colors">
                        {{ $order->food->name_en }}
                    </h4>
                    
                    <div class="flex items-center gap-4 text-gray-400 text-xs mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            Qty: {{ $order->quantity }}
                        </span>
                        <span class="flex items-center gap-1 {{ $isDelayed ? 'text-red-400' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $waitTime }} min ago
                        </span>
                    </div>

                    @if($order->notes)
                        <div class="mb-4 p-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                            <p class="text-yellow-400 text-xs flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                {{ $order->notes }}
                            </p>
                        </div>
                    @endif

                    <!-- Action Button -->
                    @if($order->status == '1')
                        <form action="{{ route('chef.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-400 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest">
                                Start Cooking
                            </button>
                        </form>
                    @else
                        <form action="{{ route('chef.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest">
                                Mark Ready
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-brand-card border border-white/5 rounded-3xl p-12 lg:p-20 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-xl">Kitchen is quiet...</p>
            <p class="text-gray-500 text-sm mt-2">No active orders at the moment</p>
        </div>
    @endif
</div>
@endsection
