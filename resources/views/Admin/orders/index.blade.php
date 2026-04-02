@extends('admin')

@section('header', 'Kitchen Management')

@section('content')
<div class="relative overflow-hidden bg-brand-card rounded-3xl border border-white/5 shadow-2xl">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
    
    <div class="overflow-x-auto relative z-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/[0.02] text-gray-400 uppercase text-[10px] font-black tracking-[0.2em] border-b border-white/5">
                <tr>
                    <th class="px-8 py-6">Order Info</th>
                    <th class="px-8 py-6">Destination</th>
                    <th class="px-8 py-6">Food Item</th>
                    <th class="px-8 py-6">Status</th>
                    <th class="px-8 py-6">Placed At</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($data as $item)
                <tr class="group hover:bg-white/[0.02] transition-all duration-300">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-brand-gold font-bold border border-white/10">
                                #{{ $item->id }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white uppercase tracking-wider">{{ $item->invoice->user->name ?? 'Guest' }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Inv #{{ $item->invoice_id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-gold/10 border border-brand-gold/20 text-brand-gold text-[10px] font-black uppercase tracking-widest">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            Table {{ $item->invoice->table->table_number ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-white font-serif font-bold text-lg group-hover:text-brand-gold transition-colors">{{ $item->food->name_en }}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Quantity: {{ $item->quantity }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if($item->status == '1')
                            <div class="flex items-center gap-2 text-orange-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Pending</span>
                            </div>
                        @elseif($item->status == '2')
                            <div class="flex items-center gap-2 text-blue-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Preparing</span>
                            </div>
                        @elseif($item->status == '3')
                            <div class="flex items-center gap-2 text-green-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Ready</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-gray-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em]">Delivered</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-medium text-gray-400">{{ $item->created_at->format('M d, H:i') }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @if($item->status == '1')
                        <form action="{{ route('orders.update', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="bg-brand-gold hover:bg-white text-black text-[10px] font-black py-2.5 px-6 rounded-xl transition-all duration-300 uppercase tracking-widest shadow-lg shadow-brand-gold/10">
                                Start Cooking
                            </button>
                        </form>
                        @elseif($item->status == '2')
                        <form action="{{ route('orders.update', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="3">
                            <button type="submit" class="bg-blue-600 hover:bg-white text-white hover:text-black text-[10px] font-black py-2.5 px-6 rounded-xl transition-all duration-300 uppercase tracking-widest shadow-lg shadow-blue-600/10">
                                Mark Ready
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-32 text-center">
                        <div class="flex flex-col items-center justify-center opacity-30">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-serif italic text-2xl text-gray-400">Silent efficiency in the kitchen.</p>
                            <p class="text-xs uppercase tracking-[0.3em] mt-2">No active orders</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
