@extends('waiter')

@section('header', 'All Orders')

@section('content')
<!-- Order Filters -->
<div class="flex flex-wrap gap-3 mb-6 lg:mb-8">
    <span class="text-xs text-gray-400 uppercase tracking-widest self-center mr-2">Filter:</span>
    <button onclick="filterOrders('all')" class="filter-btn active px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-emerald-500 text-white border border-emerald-500 transition-all" data-filter="all">
        All
    </button>
    <button onclick="filterOrders('3')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-green-500 border border-green-500/20 hover:border-green-500/50 transition-all" data-filter="3">
        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
        Ready
    </button>
    <button onclick="filterOrders('2')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-blue-500 border border-blue-500/20 hover:border-blue-500/50 transition-all" data-filter="2">
        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
        Cooking
    </button>
    <button onclick="filterOrders('1')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-orange-500 border border-orange-500/20 hover:border-orange-500/50 transition-all" data-filter="1">
        <span class="inline-block w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
        Pending
    </button>
    <button onclick="filterOrders('4')" class="filter-btn px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest bg-white/5 text-gray-500 border border-gray-500/20 hover:border-gray-500/50 transition-all" data-filter="4">
        Delivered
    </button>
</div>

<!-- Orders Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6">
    @forelse($data as $item)
        <div class="order-row bg-brand-card border border-white/5 rounded-2xl p-4 lg:p-5 {{ $item->status == '3' ? 'border-green-500/50 ring-1 ring-green-500/20' : '' }}" data-status="{{ $item->status }}">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-emerald-500 font-bold border border-white/10">
                        #{{ $item->id }}
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase">
                        Table {{ $item->invoice->table->table_number ?? 'N/A' }}
                    </span>
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
                @elseif($item->status == '3')
                    <span class="flex items-center gap-1 text-green-500">
                        <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase">Ready</span>
                    </span>
                @else
                    <span class="flex items-center gap-1 text-gray-500">
                        <span class="h-2 w-2 rounded-full bg-gray-500"></span>
                        <span class="text-[10px] font-bold uppercase">Delivered</span>
                    </span>
                @endif
            </div>

            <h4 class="text-lg font-serif font-bold text-white mb-2">{{ $item->food->name_en }}</h4>

            <div class="flex items-center gap-4 text-gray-400 text-xs mb-3">
                <span>Qty: {{ $item->quantity }}</span>
                <span>{{ $item->created_at->format('H:i') }}</span>
            </div>

            @if($item->notes)
                <div class="mb-3 p-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <p class="text-yellow-400 text-xs">{{ $item->notes }}</p>
                </div>
            @endif

            @if($item->status == '3')
                <form action="{{ route('waiter.orders.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="4">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white text-xs font-bold py-3 rounded-xl transition-all uppercase tracking-widest flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Deliver
                    </button>
                </form>
            @elseif($item->status == '4')
                <div class="w-full bg-gray-700/50 text-gray-400 text-xs font-bold py-3 rounded-xl text-center uppercase tracking-widest">
                    Completed
                </div>
            @else
                <div class="w-full bg-white/5 text-gray-500 text-xs font-bold py-3 rounded-xl text-center uppercase tracking-widest">
                    In Kitchen
                </div>
            @endif
        </div>
    @empty
        <div class="col-span-full bg-brand-card border border-white/5 rounded-2xl p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-lg">No orders found</p>
        </div>
    @endforelse
</div>

<script>
function filterOrders(status) {
    const cards = document.querySelectorAll('.order-row');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-emerald-500', 'text-white');
        btn.classList.add('bg-white/5');
    });
    const activeBtn = document.querySelector(`[data-filter="${status}"]`);
    activeBtn.classList.add('active', 'bg-emerald-500', 'text-white');
    activeBtn.classList.remove('bg-white/5');
    
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection
