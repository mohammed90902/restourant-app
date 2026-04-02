@extends('admin')

@section('header', isset($data) ? 'Update Category' : 'Create New Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors flex items-center space-x-2 font-bold text-sm uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Categories</span>
        </a>
    </div>

    <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100">
        <form action="{{ isset($data) ? route('categories.update', ['category' => $data->id]) : route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($data)
                @method('PUT')
            @endisset

            <div class="space-y-6">
                <x-input title="English Name" name="name_en" type="text" :data="$data->name_en ?? old('name_en') ?? ''" />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-input title="Arabic Name" name="name_ar" type="text" :data="$data->name_ar ?? old('name_ar') ?? ''" />
                    <x-input title="Kurdish Name" name="name_ckb" type="text" :data="$data->name_ckb ?? old('name_ckb') ?? ''" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Category Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:border-orange-400 transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <label for="image" class="relative cursor-pointer bg-transparent rounded-md font-bold text-orange-600 hover:text-orange-500">
                                <span>Upload a branding image</span>
                                <input id="image" name="image" type="file" class="sr-only">
                            </label>
                            <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                        </div>
                    </div>
                </div>

                <x-button :checkifupdate="isset($data)" />
            </div>
        </form>
    </div>
</div>
@endsection