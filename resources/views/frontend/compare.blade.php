<x-frontend-layout>
    <section>
        <div class="container py-10">
            <h1 class="text-3xl font-bold text-center">
                Compare Result for {{ $q }}
            </h1>

            <div class="grid grid-cols-3 gap-4 py-5">
                @foreach ($results as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout>
