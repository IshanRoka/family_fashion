<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{ asset('front/assets/css/styles.css') }}" />

    <title>ecommerce Website</title>
</head>
<style>
    * {
        outline: none;
    }

    .search-form {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .search {
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
        border: 1px solid black;
        outline: none;
    }

    .search-icon {
        font-size: 2.6rem;
        padding: 0.4rem 0.6rem;
        border-radius: 50%;
    }

    button {
        border: none;
        background: transparent;
    }
</style>
<script>
    function showSuccessMessage(message) {
        var messageDiv = $('<div></div>')
            .text(message)
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'padding': '10px 20px',
                'background-color': '#28a745',
                'color': '#fff',
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
</script>

<body>
    <header class="header" id="header">
        <div class="navigation">
            <div class="nav-center container d-flex">
                <a href="{{ route('frontend.index') }}" class="logo">
                    <h1>Family Fashion</h1>
                </a>
                <ul class="nav-list d-flex">
                    <li class="nav-item">
                        <a href="{{ route('frontend.index') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.product') }}" class="nav-link">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.men') }}" class="nav-link">Men</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.women') }}" class="nav-link">Women</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.kid') }}" class="nav-link">Kid</a>
                    </li>

                </ul>
                <a href="{{ route('frontend.userdetails') }}" class="icon">
                    <i class="bx bx-user"></i>
                </a>
                <div class="icons d-flex">
                    <div class="icon">
                        <form class="search-form" action="{{ route('frontend.search') }}">

                            <input type="text" class="search" name="search" placeholder="Enter product name......">
                            <button> <i class="bx bx-search search-icon"></i></button>
                        </form>
                    </div>
                </div>

                <a href="{{ route('frontend.login') }}" class="icon"
                    style="border: 1px solid black; font-size: 1.8rem; border-radius: 10px; padding: 0rem 1.4rem; color: black; border: none">
                    Login
                </a>
                <div class="hamburger">
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <img src="{{ asset('storage/product/' . $details['image']) }}"
                                    alt="{{ $details['name'] }}" />
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
                                    <button type="button" class="btn-qty btn-increase"
                                        data-id="{{ $id }}">+</button>
                                    <input style="border: none;" type="text" name="quantity"
                                        value="{{ $details['quantity'] }}" class="qty-input"
                                        data-id="{{ $id }}" min="1" readonly>
                                    <button type="button" class="btn-qty btn-decrease"
                                        data-id="{{ $id }}">-</button>
                                </div>
                            </td>
                            <td>
                                <input style="border: none; width: 100px;" type="text" name="total_price"
                                    class="sub-total"
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
                                    <input type="hidden" name="qty" class="order-qty"
                                        data-id="{{ $id }}" value="{{ $details['quantity'] }}">
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
                const hiddenInput = document.querySelector(`.order-qty[data-id="${productId}"]`);
                if (hiddenInput) {
                    hiddenInput.value = qtyInput.value;
                }
            }

            $(document).ready(function() {
                $('.btn-order').on('click', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');
                    Swal.fire({
                        title: 'Confirm Order',
                        text: "Do you want to place this order?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, place order!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                $('#removeAddtocart').on('click', function(e) {
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

            });
        </script>

        </script>
