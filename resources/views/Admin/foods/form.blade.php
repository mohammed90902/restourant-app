@extends('admin')

@section('header', isset($food) ? 'Update Food Item' : 'Create New Food')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('foods.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors flex items-center space-x-2 font-bold text-sm uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Menu</span>
        </a>
    </div>

    <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100">
        <form action="{{ isset($food) ? route('foods.update', ['food' => $food->id]) : route('foods.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($food)
                @method('PUT')
            @endisset

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    @if(!isset($food))
                    <div class="mb-4">
                        <label for="sub_category_id" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Category Selection</label>
                        <select class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition-all @error('sub_category_id') border-red-500 @enderror" id="sub_category_id" name="sub_category_id" required>
                            <option value="">Select SubCategory</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" 
                                    {{ (old('sub_category_id') ?? request('sub_category') ?? '') == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->name_en }} ({{ $subCategory->category->name_en ?? 'No Category' }})
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                        <input type="hidden" name="sub_category_id" value="{{ $food->sub_category_id }}">
                    @endif

                    <x-input title="English Name" name="name_en" type="text" :data="$food->name_en ?? old('name_en') ?? ''" />
                    <x-input title="Price (USD)" name="price" type="number" step="0.01" :data="$food->price ?? old('price') ?? ''" />
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <x-input title="Arabic Name" name="name_ar" type="text" :data="$food->name_ar ?? old('name_ar') ?? ''" />
                    <x-input title="Kurdish Name" name="name_ckb" type="text" :data="$food->name_ckb ?? old('name_ckb') ?? ''" />
                </div>
            </div>

            <div class="mt-8 space-y-6">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Food Presentation (Image)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:border-orange-400 transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-transparent rounded-md font-bold text-orange-600 hover:text-orange-500">
                                    <span>Upload a file</span>
                                    <input id="image" name="image" type="file" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-xs text-red-600 font-bold uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_available" name="is_available" class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2" 
                        {{ (isset($food) && $food->is_available) || old('is_available') ? 'checked' : '' }}>
                    <label for="is_available" class="ml-3 text-sm font-bold text-gray-700 uppercase">Marker as Available</label>
                </div>

                <x-button :checkifupdate="isset($food)" />
            </div>
        </form>
    </div>
</div>
@endsection