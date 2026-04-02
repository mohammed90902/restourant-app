@extends('chef')

@section('header', 'Menu Reference')

@section('content')
<!-- Notice -->
<div class="mb-6 lg:mb-8 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
    <p class="text-blue-400 text-sm flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span><strong>Read-Only View:</strong> This is a reference list of menu items. Contact admin to make changes.</span>
    </p>
</div>

<!-- Menu Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
    @forelse($data as $food)
        <div class="bg-brand-card border border-white/5 rounded-2xl p-4 lg:p-5 hover:border-orange-500/20 transition-all">
            <div class="flex items-start justify-between mb-3">
                <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">
                    {{ $food->sub_category->name_en ?? 'Uncategorized' }}
                </span>
                <span class="text-[10px] px-2 py-1 rounded-full bg-white/5 text-gray-300">
                    ID: {{ $food->id }}
                </span>
            </div>

            <h3 class="text-lg font-serif font-bold text-white mb-2">{{ $food->name_en }}</h3>
            
            @if($food->name_ar)
                <p class="text-gray-400 text-sm mb-3" dir="rtl">{{ $food->name_ar }}</p>
            @endif

            @if($food->description)
                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $food->description }}</p>
            @endif

            <div class="flex items-center justify-between pt-3 border-t border-white/5">
                <span class="text-xs text-gray-400">
                    @if($food->status)
                        <span class="flex items-center gap-1 text-green-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                            Available
                        </span>
                    @else
                        <span class="flex items-center gap-1 text-red-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                            Unavailable
                        </span>
                    @endif
                </span>
                <span class="text-xs text-gray-500">
                    Updated {{ $food->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-brand-card border border-white/5 rounded-2xl p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-gray-400 font-serif italic text-lg">No menu items available</p>
        </div>
    @endforelse
</div>
@endsection
