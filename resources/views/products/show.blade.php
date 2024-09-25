@php
    use Carbon\Carbon;

    $formatted_date = Carbon::parse($product->created_at)->format('M d, Y');
    $formatted_price = number_format($product->price, 0, '.', ',');
@endphp

<x-app-layout>
    <div class='max-w-[560px] mx-auto py-12'>
        <div class='card'>
            <div class="card-body">
                <div>
                    <h1 class="heading">{{ $product->name }}</h1>
                    <h2 class="heading text-2xl">₱{{ $formatted_price }}</h2>
                    <span class="badge text-bg-primary">{{ $formatted_date }}</span>
                </div>
    
                <hr>
    
    
                <div class="grid gap-4">
                    <div>{{ $product->description }}</div>
    
                    <div class="flex gap-2">
                        <x-primary-link href="{{ route('products.edit', $product) }}">{{ __('Edit') }}</x-primary-link>
                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-primary-button class='bg-red-700 hover:bg-red-600'>{{ __('Delete') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>