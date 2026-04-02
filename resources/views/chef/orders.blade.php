@extends('chef')

@section('header', 'Order Queue')

@section('content')
<!-- Order Filters -->
<div class="flex flex-wrap gap-3 mb-6 lg:mb-8">
    <span class="text-xs text-gray-400 uppercase tracking-widest self-center mr-2">Filter:</span>
    <button onclick="filterOrders('all')" class="filter-btn active px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-white border border-white/10 hover:border-orange-500/50 transition-all" data-filter="all">
        All Orders
    </button>
    <button onclick="filterOrders('1')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-orange-500 border border-orange-500/20 hover:border-orange-500/50 transition-all" data-filter="1">
        <span class="inline-block w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></span>
        Pending
    </button>
    <button onclick="filterOrders('2')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-blue-500 border border-blue-500/20 hover:border-blue-500/50 transition-all" data-filter="2">
        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
        Cooking
    </button>
    <button onclick="filterOrders('3')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-green-500 border border-green-500/20 hover:border-green-500/50 transition-all" data-filter="3">
        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
        Ready
    </button>
</div>

<!-- Orders Table (Desktop) -->
<div class="hidden lg:block relative overflow-hidden bg-brand-card rounded-3xl border border-white/5 shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/[0.02] text-gray-400 uppercase text-[10px] font-black tracking-[0.2em] border-b border-white/5">
                <tr>
                    <th class="px-6 py-5">Order</th>
                    <th class="px-6 py-5">Table</th>
                    <th class="px-6 py-5">Item</th>
                    <th class="px-6 py-5">Qty</th>
                    <th class="px-6 py-5">Notes</th>
                    <th class="px-6 py-5">Wait Time</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($data as $item)
                    @php
                        $waitTime = $item->created_at->diffInMinutes(now());
                        $isDelayed = $waitTime > 15;
                    @endphp
                    <tr class="order-row group hover:bg-white/[0.02] transition-all duration-300 {{ $isDelayed ? 'bg-red-500/5' : '' }}" data-status="{{ $item->status }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 font-bold border border-white/10">
                                    #{{ $item->id }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-500 text-xs font-black uppercase">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $item->invoice->table->table_number ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-white font-serif font-bold text-lg group-hover:text-orange-500 transition-colors">
                                {{ $item->food->name_en }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-white font-bold">{{ $item->quantity }}</span>
                        </td>
                        <td class="px-6 py-5 max-w-xs">
                            @if($item->notes)
                                <span class="text-yellow-400 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $item->notes }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-sm {{ $isDelayed ? 'text-red-400 font-bold' : 'text-gray-400' }}">
                                {{ $waitTime }} min
                                @if($isDelayed)
                                    <span class="block text-[10px] text-red-500">DELAYED!</span>
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @if($item->status == '1')
                                <span class="flex items-center gap-2 text-orange-500">
                                    <span class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                                    <span class="text-xs font-black uppercase tracking-widest">Pending</span>
                                </span>
                            @elseif($item->status == '2')
                                <span class="flex items-center gap-2 text-blue-500">
                                    <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                                    <span class="text-xs font-black uppercase tracking-widest">Cooking</span>
                                </span>
                            @elseif($item->status == '3')
                                <span class="flex items-center gap-2 text-green-500">
                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                    <span class="text-xs font-black uppercase tracking-widest">Ready</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            @if($item->status == '1')
                                <form action="{{ route('chef.orders.update', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="2">
                                    <button type="submit" class="bg-orange-500 hover:bg-orange-400 text-white text-[10px] font-black py-2.5 px-5 rounded-xl transition-all duration-300 uppercase tracking-widest">
                                        Start
                                    </button>
                                </form>
                            @elseif($item->status == '2')
                                <form action="{{ route('chef.orders.update', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="3">
                                    <button type="submit" class="bg-green-600 hover:bg-green-500 text-white text-[10px] font-black py-2.5 px-5 rounded-xl transition-all duration-300 uppercase tracking-widest">
                                        Ready
                                    </button>
                                </form>
                            @else
                                <span class="text-green-500 text-xs font-bold uppercase">Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-20 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-400 font-serif italic text-xl">All caught up!</p>
                            <p class="text-gray-500 text-sm mt-2">No orders in queue</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Orders Cards (Mobile) -->
<div class="lg:hidden space-y-4">
    @forelse($data as $item)
        @php
            $waitTime = $item->created_at->diffInMinutes(now());
            $isDelayed = $waitTime > 15;
        @endphp
        <div class="order-row bg-brand-card border {{ $isDelayed ? 'border-red-500/50' : 'border-white/5' }} rounded-2xl p-4 relative" data-status="{{ $item->status }}">
            @if($isDelayed)
                <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl rounded-tr-2xl">
                    DELAYED
                </div>
            @endif

            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-orange-500 font-bold border border-white/10">
                        #{{ $item->id }}
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-orange-500/10 text-orange-500 text-[10px] font-black uppercase">
                            Table {{ $item->invoice->table->table_number ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                @if($item->status == '1')
                    <span class="flex items-center gap-1 text-orange-500">
                        <span class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase">Pending</span>
                    </span>
                @elseif($item->status == '2')
                    <span class="flex items-center gap-1 text-blue-500">
                        <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase">Cooking</span>
                    </span>
                @else
                    <span class="flex items-center gap-1 text-green-500">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        <span class="text-[10px] font-bold uppercase">Ready</span>
                    </span>
                @endif
            </div>

            <h4 class="text-lg font-serif font-bold text-white mb-2">{{ $item->food->name_en }}</h4>

            <div class="flex items-center gap-4 text-gray-400 text-xs mb-3">
                <span>Qty: {{ $item->quantity }}</span>
                <span class="{{ $isDelayed ? 'text-red-400' : '' }}">{{ $waitTime }} min wait</span>
            </div>

            @if($item->notes)
                <div class="mb-3 p-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <p class="text-yellow-400 text-xs">{{ $item->notes }}</p>
                </div>
            @endif

            @if($item->status == '1')
                <form action="{{ route('chef.orders.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="2">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-400 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest">
                        Start Cooking
                    </button>
                </form>
            @elseif($item->status == '2')
                <form action="{{ route('chef.orders.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="3">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest">
                        Mark Ready
                    </button>
                </form>
            @endif
        </div>
    @empty
        <div class="bg-brand-card border border-white/5 rounded-2xl p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-lg">All caught up!</p>
        </div>
    @endforelse
</div>

<script>
function filterOrders(status) {
    const rows = document.querySelectorAll('.order-row');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => btn.classList.remove('active', 'bg-orange-500', 'text-white'));
    document.querySelector(`[data-filter="${status}"]`).classList.add('active', 'bg-orange-500', 'text-white');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
