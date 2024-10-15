@include('frontend.layouts.header')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    body {
        padding: 5rem 7rem;
    }

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

    .cart-table {
        border-collapse: collapse;
        font-size: 18px;
        margin: 4rem 0;
    }

    .cart-table thead tr {
        background-color: #f4f4f4;
        border-bottom: 2px solid #ddd;
    }

    .cart-table th,
    .cart-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }

    .cart-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .inline-form {
        display: inline-block;
        margin-right: 5px;
    }

    .btn {
        padding: 8px 12px;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-remove {
        background-color: #ff4d4d;
        color: white;
        border-radius: 5px;
    }

    .btn-remove:hover {
        background-color: #ff1a1a;
    }

    .btn-order {
        background-color: #4caf50;
        color: white;
        border-radius: 5px;
    }

    .btn-order:hover {
        background-color: #45a049;
    }

    h2 {
        text-align: center;
        font-size: 3rem;
        margin: 4rem 0;
    }
</style>
{{-- <div class="container cart">
    <div id="cart-wrapper"> <!-- This will allow us to update the form content -->
        <form id="cart">
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
                            <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" height="30px"
                                width="30px">
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
                                    style="width: 40px; text-align: center; border: 1px solid #ccc; border-radius: 5px;"
                                    type="text" name="qty" id="qty-{{ $item['id'] }}"
                                    value="{{ $item['qty'] }}" readonly>
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
</div> --}}

<h2>Your Cart</h2>

@if (session('cart') && count(session('cart')) > 0)
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('cart') as $id => $details)
                <tr>
                    <td>{{ $details['name'] }}</td>
                    <td>{{ $details['quantity'] }}</td>
                    <td>{{ number_format($details['price'], 2) }}</td>
                    <td>
                        <form action="{{ route('removeFromCart') }}" method="POST" class="inline-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="submit" class="btn btn-remove">Remove</button>
                        </form>
                        <form action="{{ route('order.save') }}" method="POST" class="inline-form">
                            @csrf
                            <input type="hidden" name="id" value="id">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="qty" value="{{ $details['quantity'] }}">
                            <input type="hidden" name="total_price"
                                value="{{ $details['price'] * $details['quantity'] }}">
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="submit" class="btn btn-order">Order</button>
                        </form>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Your cart is empty.</p>
@endif

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


    $(document).ready(function() {
        $('.checkout').on('click', function(e) {
            e.preventDefault();
            let formData = $('#cart').serialize();
            $.ajax({
                url: '{{ route('order.save') }}',
                type: 'POST',
                data: formData,
                success: function(response) {

                    showSuccessMessage(
                        'order placed sucess fully');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating status:', xhr.responseJSON.message);
                }
            });
        });
    });
</script>

</script>
