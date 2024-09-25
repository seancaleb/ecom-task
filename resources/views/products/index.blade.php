@php
    use Carbon\Carbon;
@endphp

{{-- @extends('layouts.app') --}}
 
{{-- @section('content') --}}
<x-app-layout>
    <div class="container py-12">
        <div class="card">
            <div class="card-header">Manage Products</div>
            <div class="card-body">
                {{-- {{ $dataTable->table() }} --}}
                <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">+ New product</a>

                <table id='products-table'>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th class="whitespace-nowrap">Created at</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <div class="whitespace-nowrap">{{ $product->name }}</div>
                                </td>
                                <td>{{ Str::words($product->description, 30) }}</td>
                                <td>₱{{ number_format($product->price, 0, '.', ',') }}</td>
                                <td>{{ Carbon::parse($product->created_at)->format('m/d/y') }}</td>
                                <td>
                                    <div class='flex gap-2'>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush --}}
</x-app-layout>
{{-- @endsection --}}

<script type='text/javascript'>
    console.log("test");
    $(document).ready(function() {
        $('#products-table').DataTable({
            processing: true,
            serverSide:true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'created_at', name: 'created_at'},
            ]
        })
    })
</script>

