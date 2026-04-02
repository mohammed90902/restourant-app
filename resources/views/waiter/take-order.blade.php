@extends('waiter')

@section('header', 'Take Order')

@section('content')
<div x-data="orderForm()" class="max-w-4xl mx-auto">
    <form @submit.prevent="submitOrder" class="space-y-6">
        <!-- Table Selection -->
        <div class="bg-brand-card border border-white/5 rounded-2xl p-4 lg:p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
                Select Table
            </h3>
            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                @foreach($tables as $table)
                    <button type="button"
                            @click="selectedTable = {{ $table->id }}"
                            :class="selectedTable === {{ $table->id }} ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white/5 text-gray-300 border-white/10 hover:border-emerald-500/50'"
                            class="p-3 rounded-xl border text-center transition-all">
                        <span class="block text-lg font-bold">{{ $table->table_number }}</span>
                        <span class="block text-[10px] uppercase tracking-widest opacity-60">Table</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Items -->
        <div class="bg-brand-card border border-white/5 rounded-2xl p-4 lg:p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Menu Items
            </h3>
            
            <!-- Search -->
            <div class="mb-4">
                <input type="text" 
                       x-model="searchTerm"
                       placeholder="Search menu..."
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-500 focus:outline-none transition-colors">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-2">
                @foreach($foods as $food)
                    <div x-show="'{{ strtolower($food->name_en) }}'.includes(searchTerm.toLowerCase())"
                         @click="addItem({{ $food->id }}, '{{ $food->name_en }}', {{ $food->price }})"
                         class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/5 hover:border-emerald-500/50 cursor-pointer transition-all group">
                        <div class="flex-1">
                            <h4 class="text-white font-medium group-hover:text-emerald-400 transition-colors">{{ $food->name_en }}</h4>
                            <p class="text-xs text-gray-400">{{ $food->sub_category->name_en ?? 'Uncategorized' }}</p>
                        </div>
                        <span class="text-emerald-400 font-bold">${{ number_format($food->price, 2) }}</span>
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-brand-card border border-white/5 rounded-2xl p-4 lg:p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Order Items
                <span x-show="items.length > 0" class="ml-2 text-xs bg-emerald-500 text-white px-2 py-0.5 rounded-full" x-text="items.length"></span>
            </h3>

            <template x-if="items.length === 0">
                <div class="text-center py-8 text-gray-500">
                    <p>No items added yet. Click on menu items to add them.</p>
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/5">
                        <div class="flex-1">
                            <h4 class="text-white font-medium" x-text="item.name"></h4>
                            <p class="text-xs text-emerald-400" x-text="'$' + item.price.toFixed(2)"></p>
                        </div>
                        
                        <!-- Quantity -->
                        <div class="flex items-center gap-2">
                            <button type="button" @click="decreaseQty(index)" class="w-8 h-8 rounded-lg bg-white/10 text-white hover:bg-red-500/20 hover:text-red-400 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="w-8 text-center text-white font-bold" x-text="item.quantity"></span>
                            <button type="button" @click="increaseQty(index)" class="w-8 h-8 rounded-lg bg-white/10 text-white hover:bg-emerald-500/20 hover:text-emerald-400 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Notes -->
                        <input type="text" 
                               x-model="item.notes"
                               placeholder="Notes..."
                               class="w-32 bg-white/5 border border-white/10 rounded-lg px-2 py-1 text-sm text-white placeholder-gray-500 focus:border-emerald-500 focus:outline-none">

                        <!-- Remove -->
                        <button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Total -->
            <div x-show="items.length > 0" class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                <span class="text-gray-400 uppercase tracking-widest text-xs font-bold">Total</span>
                <span class="text-2xl font-serif font-black text-emerald-400" x-text="'$' + total.toFixed(2)"></span>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" 
                :disabled="!selectedTable || items.length === 0 || submitting"
                :class="(!selectedTable || items.length === 0) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-emerald-400'"
                class="w-full bg-emerald-500 text-white font-bold py-4 rounded-xl transition-all uppercase tracking-widest flex items-center justify-center gap-2">
            <span x-show="!submitting">Place Order</span>
            <span x-show="submitting">Placing Order...</span>
            <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </form>
</div>

<script>
function orderForm() {
    return {
        selectedTable: {{ $selectedTable ? $selectedTable->id : 'null' }},
        items: [],
        searchTerm: '',
        submitting: false,
        
        get total() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        
        addItem(id, name, price) {
            const existing = this.items.find(i => i.food_id === id);
            if (existing) {
                existing.quantity++;
            } else {
                this.items.push({ food_id: id, name, price, quantity: 1, notes: '' });
            }
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
        },
        
        increaseQty(index) {
            this.items[index].quantity++;
        },
        
        decreaseQty(index) {
            if (this.items[index].quantity > 1) {
                this.items[index].quantity--;
            } else {
                this.removeItem(index);
            }
        },
        
        async submitOrder() {
            if (!this.selectedTable || this.items.length === 0) return;
            
            this.submitting = true;
            
            const formData = {
                table_id: this.selectedTable,
                items: this.items.map(i => ({
                    food_id: i.food_id,
                    quantity: i.quantity,
                    notes: i.notes || null
                }))
            };
            
            try {
                const response = await fetch('{{ route("waiter.store-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                });
                
                if (response.ok) {
                    window.location.href = '{{ route("waiter.orders") }}';
                } else {
                    alert('Failed to place order. Please try again.');
                    this.submitting = false;
                }
            } catch (error) {
                alert('Error placing order. Please try again.');
                this.submitting = false;
            }
        }
    }
}
</script>
@endsection
