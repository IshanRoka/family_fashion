@include('frontend.layouts.secondHeader')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    body {
        padding: 0rem 7rem;
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
        font-size: 14px;
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
        font-size: 14px;
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
        font-size: 2rem;
        margin: 4rem 0;
    }

    .qty-input {
        text-align: center;
        width: 40px;
    }
</style>

<h2>My Cart</h2>
@if (session('error'))
    <script>
        showErrorMessage("{{ session('error') }}");
    </script>
@endif

<div class="overlay" id="overlay"></div>
<div class="loader" id="loader"></div>


@if (session('cart.' . auth()->id()) && count(session('cart.' . auth()->id())) > 0)
    <form id="bulkOrderForm">
        @csrf
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>S.No</th>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price per Quantity</th>
                    <th>Size</th>
                    <th>Available Qty</th>
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
                        <td>
                            <input type="checkbox" name="product[{{ $id }}]" value="{{ $id }}"
                                class="select-product" style="width: 16px;">
                            <input type="hidden" value="{{ $id }}" name="productId[]">
                        </td>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $details['name'] ?? 'Unknown Product' }}</td>
                        <td>
                            <img src="{{ asset('storage/product/' . $details['image']) }}"
                                alt="{{ $details['name'] }}" />
                        </td>
                        <td>{{ number_format($details['price'], 2) }}</td>
                        <td>{{ $details['size'] }}</td>
                        <td>
                            <p class="available_qty"> {{ $details['available_qty'] }}</p>
                        </td>
                        <td>
                            <div class="quantity-wrapper">
                                <button type="button" class="btn-qty btn-increase"
                                    data-id="{{ $id }}">+</button>
                                <input style="border: none;" type="text"
                                    name="product[{{ $id }}][quantity]" value="{{ $details['quantity'] }}"
                                    class="qty-input" data-id="{{ $id }}" min="1" readonly>
                                <button type="button" class="btn-qty btn-decrease"
                                    data-id="{{ $id }}">-</button>
                            </div>
                        </td>
                        <td>
                            <input style="border: none; width: 100px;" type="text"
                                name="product[{{ $id }}][total_price]" class="sub-total"
                                value="{{ number_format($details['price'] * $details['quantity'], 2) }}" readonly>
                        </td>
    </form>
    <td>
        <form id="removeAddtocart" class="inline-form removeAtc">
            @csrf
            <input type="hidden" name="product_id" value="{{ $id }}">
            <button type="submit" class="btn btn-remove">Remove</button>
        </form>
    </td>
    </tr>
@endforeach
<button type="submit" class="btn btn-order">Order Now</button>

</tbody>
</table>
@else
<p>Cart is empty.</p>
@endif
<script>
    function numberFormat(number) {
        return parseFloat(number).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function updateSubtotal(qtyInput) {
        const productId = qtyInput.getAttribute('data-id');
        const pricePerUnit = parseFloat(qtyInput.closest('tr').querySelector('td:nth-child(5)').innerText.replace(/,/g,
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
        const hiddenInput = document.querySelector(`.order-qty[data-id="${productId}"]`);
        if (hiddenInput) {
            hiddenInput.value = qtyInput.value;
        }
    }

    $(document).ready(function() {

        $('.removeAtc').on('click', function(e) {
            e.preventDefault();
            const form = $(this);
            let formData = form.serialize();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this item from the cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('removeFromCart') }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            form.closest('tr').remove();
                            if ($('.cart-table tbody tr').length === 0) {
                                $('.cart-table').replaceWith(
                                    '<p>Your cart is empty.</p>');
                            }
                            $('.icon .d-flex').text(response.totalQuantity);
                            Swal.fire('Removed!', response.message, 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON.message, 'error');
                        }
                    });
                }

            });
        });

        $('.btn-order').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const formData = new FormData(form[0]);
            Swal.fire({
                title: 'Confirm Order',
                text: 'Do you want to place this order?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, place order!',
            }).then((result) => {
                if (result.isConfirmed) {

                    $('.loader').show();
                    $('.overlay').show();
                    $.ajax({
                        url: '{{ route('order.bluk') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // showSuccessMessage("product ordered successfully");
                            window.location.href = '{{ route('order.confirm') }}';

                        },
                        error: function(xhr) {
                            showErrorMessage(
                                'Error ordering the product: ' + (xhr
                                    .responseJSON?.message || 'Unknown error')
                            );
                        },
                        complete: function() {
                            $('.loader').hide();
                            $('.overlay').hide();
                        },
                    });
                }
            });
        });

    });
</script>

</script>
