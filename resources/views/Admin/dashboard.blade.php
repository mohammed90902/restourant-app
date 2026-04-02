@extends('admin')

@section('header', 'Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
    <!-- Stats Cards -->
    @php
        $stats = [
            ['Total Orders', \App\Models\InvoiceFood::count(), 'brand-gold', 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
            ['Revenue', '$' . number_format(\App\Models\Invoice::sum('total_price'), 2), 'green-500', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['Active Menu', \App\Models\Food::count(), 'blue-500', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13'],
            ['Tables', \App\Models\Table::count(), 'purple-500', 'M4 6h16M4 12h16m-7 6h7'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="group bg-brand-card border border-white/5 rounded-3xl p-8 hover:border-brand-gold/30 transition-all duration-500 hover:-translate-y-1 shadow-2xl">
        <div class="flex justify-between items-start mb-6">
            <div class="p-4 rounded-2xl bg-white/5 text-{{ $stat[2] }} group-hover:scale-110 transition-transform duration-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat[3] }}"></path>
                </svg>
            </div>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $stat[0] }}</span>
        </div>
        <h3 class="text-3xl font-serif font-black text-white tracking-tight">{{ $stat[1] }}</h3>
    </div>
    @endforeach
</div>

<div class="relative">
    <div class="flex items-center justify-between mb-8">
        <div>
            <span class="text-brand-gold font-bold tracking-[0.3em] uppercase text-[10px] mb-2 block">Live Monitoring</span>
            <h3 class="text-3xl font-serif font-black text-white uppercase tracking-tighter">Kitchen Quick View</h3>
        </div>
        <div class="h-px flex-1 mx-10 bg-gradient-to-r from-white/10 to-transparent"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @php
            $pendingOrders = \App\Models\InvoiceFood::with('food')->where('status', '1')->take(6)->get();
        @endphp

        @forelse($pendingOrders as $order)
        <div class="group bg-brand-card border border-white/5 rounded-3xl p-6 hover:border-brand-gold/30 transition-all duration-500 flex items-center gap-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-gold/5 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-brand-gold/10 transition-colors"></div>
            
            <div class="relative w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-brand-gold border border-white/10 group-hover:border-brand-gold/30 transition-all">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <div class="relative">
                <h4 class="font-serif font-bold text-lg text-white group-hover:text-brand-gold transition-colors">{{ $order->food->name_en }}</h4>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Order #{{ $order->id }}</span>
                    <span class="h-1 w-1 rounded-full bg-orange-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-orange-400">Pending</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-brand-card border border-white/5 rounded-3xl text-center">
            <p class="text-gray-500 font-serif italic text-xl">The kitchen is currently quiet...</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
