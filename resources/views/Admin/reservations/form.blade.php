@extends('admin')

@section('header', isset($data) ? 'Update Reservation' : 'Create Reservation')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('reservations.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors flex items-center space-x-2 font-bold text-sm uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Reservations</span>
        </a>
    </div>

    <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100 shadow-sm">
        <form action="{{ isset($item) ? route('reservations.update', $item->id) : route('reservations.store') }}" method="POST">
            @csrf
            @isset($item)
                @method('PUT')
            @endisset

            <div class="space-y-6">
                <x-input title="Guest Name" name="name" type="text" :data="$item->name ?? old('name') ?? ''" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-input title="Phone Number" name="phone_number" type="text" :data="$item->phone_number ?? old('phone_number') ?? ''" />
                    <x-input title="Reservation Time" name="hour" type="text" :placeholder="'e.g. 19:30'" :data="$item->hour ?? old('hour') ?? ''" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-input title="Number of Chairs" name="chair" type="number" :data="$item->chair ?? old('chair') ?? ''" />
                    
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">Select Table</label>
                        <select name="table_id" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:border-brand-gold focus:ring-brand-gold focus:ring-opacity-50 transition-all duration-300">
                            <option value="">Select a table</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}" {{ (isset($item) && $item->table_id == $table->id) ? 'selected' : '' }}>
                                    Table {{ $table->table_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-button :checkifupdate="isset($item)" />
            </div>
        </form>
    </div>
</div>
@endsection
