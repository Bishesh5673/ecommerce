@props(['product'])

<div class="relative bg-slate-100 hover:shadow-lg duration-200 rounded-lg overflow-hidden">
    <img class="h-[200px] w-full object-cover" src="{{ asset(Storage::url($product->images[0])) }}"
        alt="{{ $product->name }}">
    @if ($product->discount > 0)
        <p class="bg-red-600 px-2 text-white w-fit absolute top-2 right-2">
            {{ $product->discount }} %
        </p>
    @endif
    <div class="p-2">
        <h2 class="text-xl">
            {{ $product->name }}
        </h2>

        <p>
            Price: <span class="text-xl">Rs. {{ $product->price }}</span>
        </p>

        <a href="{{ route('product', $product->id) }}" class="underline text-primary">view details</a>
    </div>
</div>
