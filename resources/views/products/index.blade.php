{{-- @extends('layouts.app') --}}
 
{{-- @section('content') --}}
<x-app-layout>
    <div class="container py-12">
        <div class="card">
            <div class="card-header">Manage Products</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-app-layout>
{{-- @endsection --}}
 
