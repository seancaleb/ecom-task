@php
    use Carbon\Carbon;

    $formatted_date = Carbon::parse($product->created_at)->format('M d, Y');
@endphp

<x-app-layout>
    <div class='max-w-[560px] mx-auto py-12'>
        <div class='card'>
            <div class="card-body">
                <div>
                    <h1 class="heading">{{ $product->name }}</h1>
                    <span >Date created: <span class="badge text-bg-primary">{{ $formatted_date }}</span></span>
                </div>
    
                <hr>
    
    
                <div class="grid gap-4">
                    <div>{{ $product->description }}</div>
    
                    <div class="flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>