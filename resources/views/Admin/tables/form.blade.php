@extends('admin')

@section('header', isset($data) ? 'Update Table' : 'Create Table')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('tables.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors flex items-center space-x-2 font-bold text-sm uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Tables</span>
        </a>
    </div>

    <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100 shadow-sm">
        <form action="{{ isset($data) ? route('tables.update', ['table' => $data->id]) : route('tables.store') }}" method="POST">
            @csrf
            @isset($data)
                @method('PUT')
            @endisset

            <div class="space-y-6">
                <x-input title="Table Designation (Number)" name="table_number" type="text" :data="$data->table_number ?? old('table_number') ?? ''" />
                
                <div class="p-6 bg-orange-50 rounded-2xl border border-orange-100">
                    <h4 class="text-xs font-black text-orange-600 uppercase tracking-widest mb-2">Internal Note</h4>
                    <p class="text-sm text-gray-600">Ensure table numbers are unique and easy for staff to locate in the dining area.</p>
                </div>

                <x-button :checkifupdate="isset($data)" />
            </div>
        </form>
    </div>
</div>
@endsection