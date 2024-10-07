@include('frontend.layouts.header')
<style>
    .increase,
    .decrease {
        cursor: pointer;
        font-size: 2.2rem;
        margin: 0 0.9rem;
    }

    .decrease {
        font-size: 3.4rem;
    }

    th {
        padding: 1rem;
    }

    .quantity-control {
        display: flex;
        align-items: center;
    }

    .total_price {
        width: 100px;
    }
</style>

<div class="container cart">
    <form action="{{ route('order.save') }}" method="post" id="cart">
        @csrf
        <table>
            <tr>
                <th>S.No</th>
                <th>Product Name</th>
                <th>Image</th>
                <th>Price Per Unit</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>

            @php
                $total = 0;
                $i = 1;
            @endphp

            @foreach ($cartItems as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                        <div class="cart-info">
                            <div>
                                <p>{{ $item['product_name'] }}</p>
                                <input type="hidden" name="product_name" value="{{ $item['product_name'] }}">
                            </div>
                        </div>
                    </td>

                    <td>
                        <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" height="30px" width="30px">
                    </td>

                    <td>
                        <div class="cart-info">
                            <div>
                                <p>Rs {{ number_format($item['price'], 2) }}</p>
                                <input type="hidden" class="product-price" id="price-{{ $item['id'] }}"
                                    value="{{ $item['price'] }}">
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="cart-info quantity-control">
                            <div class="decrease" data-id="{{ $item['id'] }}">-</div>
                            <input
                                style="  width: 40px; text-align: center; border: 1px solid #ccc; border-radius: 5px;"
                                type="text" name="qty" id="qty-{{ $item['id'] }}" value="{{ $item['qty'] }}"
                                readonly>
                            <div class="increase" data-id="{{ $item['id'] }}">+</div>
                        </div>
                    </td>

                    <td>
                        <input style="border: none" class="total_price" type="text" name="total_price"
                            id="subtotal-{{ $item['id'] }}"
                            value="Rs {{ number_format($item['price'] * $item['qty'], 2) }}" readonly>
                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                    </td>

                    <td>
                        <button type="submit" class="checkout btn">Order Now</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
</div>

<script>
    document.querySelectorAll('.decrease, .increase').forEach(button => {
        button.addEventListener('click', (event) => {
            const button = event.target;
            const id = button.getAttribute('data-id');
            const qtyInput = document.getElementById('qty-' + id);
            const productPrice = parseFloat(document.getElementById('price-' + id).value);
            let currentQty = parseInt(qtyInput.value);

            if (button.classList.contains('decrease')) {
                if (currentQty > 0) {
                    currentQty -= 1;
                }
            } else if (button.classList.contains('increase')) {
                currentQty += 1;
            }
            qtyInput.value = currentQty;

            const subtotal = currentQty * productPrice;

            document.getElementById('subtotal-' + id).value = 'Rs ' + subtotal.toFixed(2);
        });
    });
</script>


@include('frontend.layouts.footer')
