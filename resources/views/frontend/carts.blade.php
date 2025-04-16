<x-frontend-layout>
    <section>
        <div class="container py-10">
            <h1 class="text-3xl font-bold text-center mb-8">
                Your Cart
            </h1>

            @forelse ($carts as $sellerId => $items)
                <div class="border border-gray-300 rounded-lg p-4 mb-6">
                    <h2 class="text-xl font-semibold mb-3">
                        Seller: {{ $items->first()->product->seller->name ?? 'Unknown Seller' }}
                    </h2>

                    <ul class="space-y-4">
                        @foreach ($items as $cart)
                            <li class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-medium">{{ $cart->product->name }}</p>
                                    <label for="quantity">Qty:</label>
                                    <input type="number" class="quantity-input border rounded px-2 py-1"
                                        data-cart-id="{{ $cart->id }}" min="1" value="{{ $cart->quantity }}">
                                </div>
                                <p class="text-right font-semibold amount-display">Rs.
                                    {{ number_format($cart->amount, 2) }}</p>
                            </li>

                            <div class="flex justify-end gap-2">
                                <form action="{{route('cart.delete', $cart->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="bg-red-600 px-2 py-1 text-white rounded">Remove</button>
                                </form>

                                <form action="" method="post">
                                    @csrf
                                    <button type="submit" class="bg-secondary px-2 py-1 text-white rounded">Order</button>
                                </form>
                            </div>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-center text-gray-500">Your cart is empty.</p>
            @endforelse
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const cartId = this.dataset.cartId;
                    const quantity = this.value;
                    const amountDisplay = this.closest('li').querySelector('.amount-display');

                    fetch("{{ route('cart.updateQuantity') }}", {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart_id: cartId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                amountDisplay.innerText = `Rs. ${data.amount}`;
                            } else {
                                alert(data.message || 'Failed to update quantity');
                            }
                        });
                });
            });
        });
    </script>

</x-frontend-layout>
