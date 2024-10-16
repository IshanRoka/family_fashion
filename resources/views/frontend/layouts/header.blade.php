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
                    <a href="{{ route('listAddtocart') }}" class="icon">
                        <i class="bx bx-cart"></i>
                        @if (isset($totalQuantity) && $totalQuantity > 0)
                            <span class="d-flex">{{ $totalQuantity }}</span>
                        @else
                            <span class="d-flex">0</span>
                        @endif
                    </a>

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
