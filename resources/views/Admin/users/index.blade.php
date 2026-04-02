@extends('admin')

@section('header', 'User Management')

@section('content')
<div class="relative overflow-hidden bg-brand-card rounded-3xl border border-white/5 shadow-2xl">
    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-gold/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>
    
    <div class="overflow-x-auto relative z-10">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/[0.02] text-gray-400 uppercase text-[10px] font-black tracking-[0.2em] border-b border-white/5">
                <tr>
                    <th class="px-8 py-6">#</th>
                    <th class="px-8 py-6">User Account</th>
                    <th class="px-8 py-6">Permissions</th>
                    <th class="px-8 py-6">Joined</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($data as $index => $item)
                <tr class="group hover:bg-white/[0.02] transition-all duration-300">
                    <td class="px-8 py-6 text-gray-500 font-bold text-xs">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-brand-gold border border-white/10 font-bold text-xs">
                                {{ substr($item->email, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-white group-hover:text-brand-gold transition-colors">{{ $item->email }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if($item->role == 1)
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-purple-500/10 border border-purple-500/20 text-purple-400 uppercase tracking-widest">Admin</span>
                        @elseif($item->role == 2)
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-blue-500/10 border border-blue-500/20 text-blue-400 uppercase tracking-widest">Server</span>
                        @else
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-white/5 border border-white/10 text-gray-400 uppercase tracking-widest">User</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</td>
                    <td class="px-8 py-6 text-right flex items-center justify-end gap-3">
                        <a href="{{ route('users.edit', $item->id) }}" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-brand-gold hover:bg-brand-gold hover:text-black transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        </a>
                        <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
