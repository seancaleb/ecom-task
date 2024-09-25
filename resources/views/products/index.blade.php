@php
    use Carbon\Carbon;

    function formatDate($date) {
        return Carbon::parse($date)->format('m/d/y');
    }

    function formatPrice($price) {
        return number_format($price, 0, '.', ',');
    }
@endphp

{{-- @extends('layouts.app') --}}
 
{{-- @section('content') --}}
<x-app-layout>
    <div class="container py-12">
        <div class="card">
            <div class="card-header">Manage Products</div>
            <div class="card-body">
                {{-- {{ $dataTable->table() }} --}}
                <x-primary-link href="{{ route('products.create') }}" class="mb-2">+ New product</x-primary-link>

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
                    {{-- <tbody>
                        @foreach ($products as $product)
                            <tr onclick="location.href='{{ route('products.show', $product) }}'" class='cursor-pointer'>
                                <td>
                                    <div class="whitespace-nowrap">{{ $product->name }}</div>
                                </td>
                                <td>{{ Str::words($product->description, 30) }}</td>
                                <td>₱{{ formatPrice($product->price) }}</td>
                                <td><div class="badge bg-primary">{{ formatDate($product->created_at) }}</div></td>
                                <td>
                                    <div class='flex gap-2'>
                                        <x-primary-link href="{{ route('products.edit', $product) }}">{{ __('Edit') }}</x-primary-link>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-primary-button class='bg-red-700 hover:bg-red-600'>{{ __('Delete') }}</x-primary-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> --}}
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
                {data: 'actions', name: 'actions'},
            ],
            "rowCallback": function( row, data, dataIndex ) {
                let productId = data.id; 
                let url = `/products/${productId}`; 

                $(row).attr('onclick', `location.href='${url}'`);
                $(row).addClass('cursor-pointer');
            },
            columnDefs: [
                {
                    targets: 0,
                    render: function(data, type, row) {
                        return '<span class="whitespace-nowrap">' + data + '</span>';
                    }
                },
                {
                    targets: 1,
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    targets: 2,
                    render: function(data, type, row) {
                        return '₱' + data;
                    }
                },
                {
                    targets: 3,
                    render: function(data, type, row) {
                        return '<div class="badge bg-primary">' + data + '</div>';
                    }
                },
               {
                    targets: 4,
                    render: function(data, type, row) {
                        return `<div class='flex gap-2'>
                                    <a class="primary-link" href="${data[0]}">{{ __('Edit') }}</a>
                                    <form action="${data[1]}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class='primary-btn bg-red-700 hover:bg-red-600'>{{ __('Delete') }}</button>
                                    </form>
                                </div>`;
                    }
               }
            ]
        })
    })
</script>

