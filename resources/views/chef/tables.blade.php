@extends('chef')

@section('header', 'Tables Overview')

@section('content')
<!-- Notice -->
<div class="mb-6 lg:mb-8 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
    <p class="text-blue-400 text-sm flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span><strong>Read-Only View:</strong> Table numbers help with order plating and serving. Contact admin to manage tables.</span>
    </p>
</div>

<!-- Tables Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 lg:gap-6">
    @forelse($data as $table)
        @php
            $hasActiveOrders = \App\Models\InvoiceFood::whereHas('invoice', function($q) use ($table) {
                $q->where('table_id', $table->id);
            })->whereIn('status', ['1', '2'])->exists();
        @endphp
        <div class="bg-brand-card border {{ $hasActiveOrders ? 'border-orange-500/50' : 'border-white/5' }} rounded-2xl p-4 lg:p-6 text-center relative">
            @if($hasActiveOrders)
                <span class="absolute -top-1 -right-1 h-3 w-3 bg-orange-500 rounded-full animate-pulse"></span>
            @endif

            <div class="w-12 h-12 lg:w-16 lg:h-16 mx-auto mb-3 rounded-2xl bg-white/5 flex items-center justify-center {{ $hasActiveOrders ? 'text-orange-500' : 'text-gray-400' }} border border-white/10">
                <svg class="w-6 h-6 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </div>

            <h3 class="text-xl lg:text-2xl font-serif font-black text-white mb-1">{{ $table->table_number }}</h3>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-3">Table</p>

            <div class="flex items-center justify-center gap-1 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm">{{ $table->capacity }} seats</span>
            </div>

            @if($hasActiveOrders)
                <div class="mt-3 pt-3 border-t border-white/5">
                    <span class="text-[10px] uppercase tracking-widest text-orange-500 font-bold">Active Orders</span>
                </div>
            @endif
        </div>
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
