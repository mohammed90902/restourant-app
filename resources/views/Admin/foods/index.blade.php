@extends('admin')

@section('header', 'Food Menu Management')

@section('content')
<div class="flex justify-between items-center mb-10">
    <a href="{{ route('foods.create') }}" class="group bg-brand-gold hover:bg-white text-black font-black py-3 px-8 rounded-2xl transition-all duration-300 uppercase tracking-widest text-xs flex items-center gap-3 shadow-lg shadow-brand-gold/20 active:scale-95">
        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Add New Food</span>
    </a>
</div>

<div class="relative overflow-hidden bg-brand-card rounded-3xl border border-white/5 shadow-2xl">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
    
    <div class="overflow-x-auto relative z-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/[0.02] text-gray-400 uppercase text-[10px] font-black tracking-[0.2em] border-b border-white/5">
                <tr>
                    <th class="px-8 py-6">#</th>
                    <th class="px-8 py-6">Food Item</th>
                    <th class="px-8 py-6">Price</th>
                    <th class="px-8 py-6">Author</th>
                    <th class="px-8 py-6">Created</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($data as $index => $item)
                <tr class="group hover:bg-white/[0.02] transition-all duration-300">
                    <td class="px-8 py-6 text-gray-500 font-bold text-xs">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-white font-serif font-bold text-lg group-hover:text-brand-gold transition-colors">{{ $item->name_en }}</span>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item->name_ckb }}</span>
                                <span class="h-1 w-1 rounded-full bg-white/20"></span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item->name_ar }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-brand-gold font-bold tracking-tighter text-lg group-hover:scale-110 transition-transform inline-block">${{ number_format($item->price, 2) }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-gray-300 uppercase tracking-widest">{{ $item->user->name ?? 'System' }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-medium text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                    </td>
                    <td class="px-8 py-6 text-right flex items-center justify-end gap-3 mt-1">
                        <a href="{{ route('foods.edit', $item->id) }}" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-brand-gold hover:bg-brand-gold hover:text-black transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        </a>
                        <form action="{{ route('foods.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-red-400 hover:bg-red-400 hover:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
