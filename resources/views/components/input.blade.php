<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ $title }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $attributes->merge(['class' => 'w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-3 transition-all']) }}
        value="{{ $data ?? old($name) }}"
    >
    @error($name)
        <p class="mt-1 text-xs text-red-600 font-bold uppercase">{{ $message }}</p>
    @enderror
</div>
