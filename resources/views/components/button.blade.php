<div class="mt-8">
    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-black py-4 px-6 rounded-2xl transition-all shadow-[0_10px_20px_rgba(234,88,12,0.2)] active:scale-[0.98] uppercase tracking-widest flex items-center justify-center space-x-2">
        @if ($checkifupdate)
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Update Item</span>
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Add to Menu</span>
        @endif
    </button>
</div>