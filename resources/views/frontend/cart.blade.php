@include('frontend.layouts.header')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    body {
        padding: 5rem 7rem;
    }

    .btn-increase,
    .btn-decrease {
        cursor: pointer;
        font-size: 2rem;
        margin: 0 0.9rem;
        text-align: center;
    }

    .btn-decrease {
        font-size: 3rem;
        text-align: center;
    }

    th {
        padding: 1rem;
    }

    table {
        border-radius: 3rem;
        border: 1px solid black;
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
        border-radius: 3rem;
        border: 1px solid black;
    }

    .cart-table thead tr {
        background-color: white !important;
        border-bottom: 2px solid #ddd;
    }

    .cart-table th,
    .cart-table td {
        text-align: center;
        padding: 12px 15px;
        border: 1px solid #ddd;
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
        transition: 0.5s;
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

    .qty-input {
        text-align: center;
        width: 40px;
    }
</style>

<h2>My Cart</h2>
@if (session('cart.' . auth()->id()) && count(session('cart.' . auth()->id())) > 0)
    <table class="cart-table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Product</th>
                <th>Image</th>
                <th>Price per quantity</th>
                <th>Size</th>
                <th>available_qty</th>
                <th>Quantity</th>
                <th>Sub Total</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 1;
            @endphp
            @foreach (session('cart.' . auth()->id()) as $id => $details)
                <tr>
                    <td>{{ $sn++ }}</td>
                    <td>{{ $details['name'] ?? 'Unknown Product' }}</td>
                    <td>
                        <img src="{{ asset('storage/product/' . $details['image']) }}" alt="{{ $details['name'] }}" />
                    </td>
                    <td>{{ number_format($details['price'], 2) }}</td>
                    <td>{{ $details['size'] }}</td>
                    <td>
                        <span class="available_qty">
                            {{ $details['available_qty'] }}
                        </span>
                    </td>
                    <td>
                        <div class="quantity-wrapper">
                            <button type="button" class="btn-qty btn-increase" data-id="{{ $id }}">+</button>
                            <input style="border: none;" type="text" name="quantity"
                                value="{{ $details['quantity'] }}" class="qty-input" data-id="{{ $id }}"
                                min="1" readonly>
                            <button type="button" class="btn-qty btn-decrease"
                                data-id="{{ $id }}">-</button>
                        </div>
                    </td>
                    <td>
                        <input style="border: none; width: 100px;" type="text" name="total_price" class="sub-total"
                            value="{{ number_format($details['price'] * $details['quantity'], 2) }}" readonly>
                    </td>
                    <td>
                        <form id="removeAddtocart" class="inline-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <button type="submit" class="btn btn-remove">Remove</button>
                        </form>
                        <form action="{{ route('order.save') }}" method="POST" class="inline-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="qty" class="order-qty" data-id="{{ $id }}"
                                value="{{ $details['quantity'] }}">
                            <input type="hidden" name="total_price" class="total-price"
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
    <p>Cart is empty.</p>
@endif
<script>
    function errorMessage(message) {
        var messageDiv = $('<div></div>')
            .text(message)
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'padding': '10px 20px',
                'background-color': 'red',
                'color': 'white',
                'border-radius': '5px',
                'z-index': '9999',
                'display': 'none',
                'box-shadow': '0 4px 8px rgba(0, 0, 0, 0.2)'
            });
        $('body').append(messageDiv);
        messageDiv.fadeIn(300).delay(3000).fadeOut(300, function() {
            $(this).remove();
        });
    }



    function numberFormat(number) {
        return parseFloat(number).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function updateSubtotal(qtyInput) {
        const productId = qtyInput.getAttribute('data-id');
        const pricePerUnit = parseFloat(qtyInput.closest('tr').querySelector('td:nth-child(4)').innerText.replace(/,/g,
            ''));
        const quantity = parseInt(qtyInput.value);
        const subtotal = (pricePerUnit * quantity).toFixed(2);
        const subtotalInput = qtyInput.closest('tr').querySelector('.sub-total');
        if (subtotalInput) {
            subtotalInput.value = numberFormat(subtotal);
        }
    }

    document.querySelectorAll('.btn-increase').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const qtyInput = this.parentElement.querySelector('.qty-input');

            let qty = parseInt(qtyInput.value);
            const availableQtySpan = row.querySelector('.available_qty');
            const availableQty = parseInt(availableQtySpan.textContent);
            // if(qty)
            if (qty > (availableQty - 1)) {
                errorMessage('Product exceeds available qty');

            } else {
                qtyInput.value = qty + 1;
                updateQuantity(qtyInput);
                updateSubtotal(qtyInput);
            }
        });
    });

    document.querySelectorAll('.btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const qtyInput = this.parentElement.querySelector('.qty-input');
            let qty = parseInt(qtyInput.value);
            let currentQty = parseInt(qtyInput.value);
            if (qty > 1) {
                qtyInput.value = qty - 1;
                updateQuantity(qtyInput);
                updateSubtotal(qtyInput);
            }
        });
    });

    function updateQuantity(qtyInput) {
        const productId = qtyInput.getAttribute('data-id');
        const hiddenInput = document.querySelector(
            `.order-qty[data-id="${productId}"]`);
        if (hiddenInput) {
            hiddenInput.value = qtyInput.value;
        }
    }

    $(document).ready(function() {
        $('#removeAddtocart').on('click', function(e) {
            e.preventDefault();
            const form = $(this);
            let formData = form.serialize();
            $.ajax({
                url: '{{ route('removeFromCart') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    form.closest('tr').remove();
                    if ($('.cart-table tbody tr').length === 0) {
                        $('.cart-table').replaceWith('<p>Your cart is empty.</p>');
                    }
                    showSuccessMessage(response.message);
                },
                error: function(xhr) {
                    showErrorMessage(xhr.responseJSON.message);
                }
            });
        });
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //     const quantityInputs = document.querySelectorAll('.qty-input');

    //     quantityInputs.forEach(input => {
    //         const productId = input.getAttribute('data-id');
    //         const availableQty = parseInt(input.closest('tr').querySelector('td:nth-child(6)')
    //             .innerText); // Get available qty from the 6th <td>

    //         // Increase Button
    //         input.closest('.quantity-wrapper').querySelector('.btn-increase').addEventListener('click',
    //             function() {
    //                 let currentQty = parseInt(input.value);
    //                 if (currentQty < availableQty) {
    //                     input.value = currentQty + 1; // Increase quantity
    //                     input.classList.remove('error'); // Remove any error styling
    //                     input.closest('tr').querySelector('.error-message').style.display =
    //                         'none'; // Hide error message
    //                 } else {
    //                     input.closest('tr').querySelector('.error-message').style.display =
    //                         'block'; // Show error message
    //                 }
    //             });

    //         // Decrease Button
    //         input.closest('.quantity-wrapper').querySelector('.btn-decrease').addEventListener('click',
    //             function() {
    //                 let currentQty = parseInt(input.value);
    //                 if (currentQty > 1) {
    //                     input.value = currentQty - 1; // Decrease quantity
    //                     input.closest('tr').querySelector('.error-message').style.display =
    //                         'none'; // Hide error message
    //                 }
    //             });
    //     });
    // });
</script>

</script>
