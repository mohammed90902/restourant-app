@extends('waiter')

@section('header', 'Tables')

@section('content')
<!-- Tables Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 lg:gap-6">
    @forelse($data as $table)
        @php
            $activeOrders = \App\Models\InvoiceFood::whereHas('invoice', function($q) use ($table) {
                $q->where('table_id', $table->id);
            })->whereIn('status', ['1', '2', '3'])->count();
            
            $readyOrders = \App\Models\InvoiceFood::whereHas('invoice', function($q) use ($table) {
                $q->where('table_id', $table->id);
            })->where('status', '3')->count();
        @endphp
        <a href="{{ route('waiter.take-order', $table->id) }}" 
           class="block bg-brand-card border {{ $activeOrders > 0 ? ($readyOrders > 0 ? 'border-green-500/50' : 'border-orange-500/50') : 'border-white/5' }} rounded-2xl p-4 lg:p-6 text-center relative hover:border-emerald-500/50 transition-all group">
            
            @if($readyOrders > 0)
                <span class="absolute -top-1 -right-1 h-5 w-5 bg-green-500 rounded-full flex items-center justify-center text-[10px] font-bold text-white animate-pulse">
                    {{ $readyOrders }}
                </span>
            @elseif($activeOrders > 0)
                <span class="absolute -top-1 -right-1 h-3 w-3 bg-orange-500 rounded-full animate-pulse"></span>
            @endif

            <div class="w-12 h-12 lg:w-16 lg:h-16 mx-auto mb-3 rounded-2xl bg-white/5 flex items-center justify-center {{ $activeOrders > 0 ? ($readyOrders > 0 ? 'text-green-500' : 'text-orange-500') : 'text-gray-400' }} border border-white/10 group-hover:text-emerald-500 group-hover:border-emerald-500/30 transition-all">
                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>

            <h3 class="text-xl lg:text-2xl font-serif font-black text-white mb-1 group-hover:text-emerald-400 transition-colors">{{ $table->table_number }}</h3>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Table</p>

            <div class="flex items-center justify-center gap-1 text-gray-400 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm">{{ $table->capacity }}</span>
            </div>

            @if($activeOrders > 0)
                <div class="mt-2 pt-2 border-t border-white/5">
                    <span class="text-[10px] uppercase tracking-widest {{ $readyOrders > 0 ? 'text-green-500' : 'text-orange-500' }} font-bold">
                        {{ $activeOrders }} Active {{ $readyOrders > 0 ? "($readyOrders ready)" : '' }}
                    </span>
                </div>
            @else
                <div class="mt-2 pt-2 border-t border-white/5">
                    <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold">Available</span>
                </div>
            @endif
        </a>
    @empty
        <div class="col-span-full bg-brand-card border border-white/5 rounded-2xl p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-lg">No tables configured</p>
        </div>
    @endforelse
</div>
@endsection
