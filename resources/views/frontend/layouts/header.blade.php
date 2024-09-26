<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">
    <link rel="stylesheet" href="{{ asset('front/assets/css/styles.css') }}" />
    <title>ecommerce Website</title>
</head>

<body>
    <header class="header" id="header">
        <div class="navigation">
            <div class="nav-center container d-flex">
                <a href="/" class="logo">
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

                <div class="icons d-flex">
                    <a href="{{ route('frontend.login') }}" class="icon">
                        <i class="bx bx-user"></i>
                    </a>
                    <div class="icon">
                        <i class="bx bx-search"></i>
                    </div>
                    <div class="icon">
                        <i class="bx bx-heart"></i>
                        <span class="d-flex">0</span>
                    </div>
                    <a href="{{ route('frontend.cart') }}" class="icon">
                        <i class="bx bx-cart"></i>
                        <span class="d-flex">0</span>
                    </a>
                </div>

                <div class="hamburger">
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
        </div>
