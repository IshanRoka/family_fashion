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

<h2>Your Cart</h2>
@if (session('cart.' . auth()->id()) && count(session('cart.' . auth()->id())) > 0)
    <table class="cart-table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Product</th>
                <th>Image</th>
                <th>Price per quantity</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Sub Total</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @php $sn = 1; @endphp
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
                        <div class="quantity-wrapper">
                            <button type="button" class="btn-qty btn-increase" data-id="{{ $id }}">+</button>
                            <input style="border: none;" type="text" name="quantity" value="{{ $details['quantity'] }}"
                                class="qty-input" data-id="{{ $id }}" min="1" readonly>
                            <button type="button" class="btn-qty btn-decrease" data-id="{{ $id }}">-</button>
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
    <p>Your cart is empty.</p>
@endif
<script>
    // Function to format a number to 2 decimal places
    function numberFormat(number) {
        return parseFloat(number).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Function to update the subtotal price based on quantity and price per unit
    function updateSubtotal(qtyInput) {
        const productId = qtyInput.getAttribute('data-id'); // Get product id from data attribute
        const pricePerUnit = parseFloat(qtyInput.closest('tr').querySelector('td:nth-child(4)').innerText.replace(/,/g,
            '')); // Get price per unit
        const quantity = parseInt(qtyInput.value); // Get quantity
        const subtotal = (pricePerUnit * quantity).toFixed(2); // Calculate subtotal
        const subtotalInput = qtyInput.closest('tr').querySelector('.sub-total'); // Get the subtotal input
        if (subtotalInput) {
            subtotalInput.value = numberFormat(subtotal); // Update subtotal value with formatted number
        }
    }

    // Add event listeners to all increase and decrease buttons
    document.querySelectorAll('.btn-increase').forEach(button => {
        button.addEventListener('click', function() {
            const qtyInput = this.parentElement.querySelector('.qty-input');
            let qty = parseInt(qtyInput.value);
            qtyInput.value = qty + 1; // Increase quantity
            updateQuantity(qtyInput); // Call function to update quantity in hidden input
            updateSubtotal(qtyInput); // Call function to update subtotal
        });
    });

    document.querySelectorAll('.btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const qtyInput = this.parentElement.querySelector('.qty-input');
            let qty = parseInt(qtyInput.value);
            if (qty > 1) { // Prevent quantity from going below 1
                qtyInput.value = qty - 1; // Decrease quantity
                updateQuantity(qtyInput); // Call function to update quantity in hidden input
                updateSubtotal(qtyInput); // Call function to update subtotal
            }
        });
    });

    // Function to update the hidden quantity input field when the quantity changes
    function updateQuantity(qtyInput) {
        const productId = qtyInput.getAttribute('data-id'); // Get product id from data attribute
        const hiddenInput = document.querySelector(
            `.order-qty[data-id="${productId}"]`); // Get corresponding hidden input
        if (hiddenInput) {
            hiddenInput.value = qtyInput.value; // Update hidden input value
        }
    }
</script>







<script>
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
                        'order placed sucess fully'
                    );
                },
                error: function(xhr, status, error) {
                    showSuccessMessage(
                        'Error updating status:',
                        xhr.responseJSON.message
                    );
                }
            });
        });

        $('#removeAddtocart').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('removeFromCart') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    const productId = $('input[name="product_id"]', this).val();
                    $(this).closest('tr').remove();
                    if ($('.cart-table tbody tr').length === 0) {
                        $('.cart-table').replaceWith('<p>Your cart is empty.</p>');
                    }

                    showSuccessMessage(response.message);
                }.bind(this),
                error: function(xhr) {
                    showSuccessMessage('Error removing product from cart:', xhr.responseJSON
                        .message);
                }
            });
        });
    });
</script>

</script>
