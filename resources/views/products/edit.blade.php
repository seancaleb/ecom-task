<x-app-layout>
    <div class='max-w-[560px] mx-auto py-12'>
        <div class="card">
            <div class="card-header">Edit product</div>
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="POST" class='grid gap-4'>
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="@old('name', $product->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <x-text-textarea id="description" class="block mt-1 w-full" name="description" :value="@old('description', $product->description)" required autofocus autocomplete="description" rows='6'/>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="@old('price', $product->price)" required autofocus autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class='flex gap-2'>
                        <x-secondary-link href="{{ route('products.index') }}">{{ __('Cancel') }}</x-secondary-link>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>