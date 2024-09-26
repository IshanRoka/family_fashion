<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Box icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/styles.css') }}" />
    <title>Boy’s T-Shirt</title>
</head>

<body>
    <!-- Navigation -->
    <div class="top-nav">
        <div class="container d-flex">
            <p>Order Online Or Call Us: (001) 2222-55555</p>
            <ul class="d-flex">
                <li><a href="#">About Us</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </div>
    <div class="navigation">
        <div class="nav-center container d-flex">
            <a href="index.html" class="logo">
                <h1>Dans</h1>
            </a>

            <ul class="nav-list d-flex">
                <li class="nav-item">
                    <a href="/" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="product.html" class="nav-link">Shop</a>
                </li>
                <li class="nav-item">
                    <a href="#terms" class="nav-link">Terms</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact</a>
                </li>
                <li class="icons d-flex">
                    <a href="login.html" class="icon">
                        <i class="bx bx-user"></i>
                    </a>
                    <div class="icon">
                        <i class="bx bx-search"></i>
                    </div>
                    <div class="icon">
                        <i class="bx bx-heart"></i>
                        <span class="d-flex">0</span>
                    </div>
                    <a href="cart.html" class="icon">
                        <i class="bx bx-cart"></i>
                        <span class="d-flex">0</span>
                    </a>
                </li>
            </ul>

            <div class="icons d-flex">
                <a href="login.html" class="icon">
                    <i class="bx bx-user"></i>
                </a>
                <div class="icon">
                    <i class="bx bx-search"></i>
                </div>
                <div class="icon">
                    <i class="bx bx-heart"></i>
                    <span class="d-flex">0</span>
                </div>
                <a href="cart.html" class="icon">
                    <i class="bx bx-cart"></i>
                    <span class="d-flex">0</span>
                </a>
            </div>

            <div class="hamburger">
                <i class="bx bx-menu-alt-left"></i>
            </div>
        </div>
    </div>

    <!-- All Products -->
    <section class="section all-products" id="products">
        <div class="top container">
            <h1>All Products</h1>
            <form>
                <select>
                    <option value="1">Defualt Sorting</option>
                    <option value="2">Sort By Price</option>
                    <option value="3">Sort By Popularity</option>
                    <option value="4">Sort By Sale</option>
                    <option value="5">Sort By Rating</option>
                </select>
                <span><i class="bx bx-chevron-down"></i></span>
            </form>
        </div>
        <div class="product-center container">
            <div class="product-item">
                <div class="overlay">
                    <a href="productDetails.html" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                    <span class="discount">40%</span>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="productDetails.html">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                    <span class="discount">40%</span>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                    <span class="discount">40%</span>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                    <span class="discount">40%</span>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                    <span class="discount">40%</span>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
            <div class="product-item">
                <div class="overlay">
                    <a href="" class="product-thumb">
                        <img src="{{ asset('front/assets/images/popup.jpg') }}" alt="" />
                    </a>
                </div>
                <div class="product-info">
                    <span>MEN'S CLOTHES</span>
                    <a href="">Concepts Solid Pink Men’s Polo</a>
                    <h4>$150</h4>
                </div>
                <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="pagination">
        <div class="container">
            <span>1</span> <span>2</span> <span>3</span> <span>4</span>
            <span><i class="bx bx-right-arrow-alt"></i></span>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="row">
            <div class="col d-flex">
                <h4>INFORMATION</h4>
                <a href="">About us</a>
                <a href="">Contact Us</a>
                <a href="">Term & Conditions</a>
                <a href="">Shipping Guide</a>
            </div>
            <div class="col d-flex">
                <h4>USEFUL LINK</h4>
                <a href="">Online Store</a>
                <a href="">Customer Services</a>
                <a href="">Promotion</a>
                <a href="">Top Brands</a>
            </div>
            <div class="col d-flex">
                <span><i class="bx bxl-facebook-square"></i></span>
                <span><i class="bx bxl-instagram-alt"></i></span>
                <span><i class="bx bxl-github"></i></span>
                <span><i class="bx bxl-twitter"></i></span>
                <span><i class="bx bxl-pinterest"></i></span>
            </div>
        </div>
    </footer>
    <!-- Custom Script -->
    <script src="./js/index.js"></script>
</body>

</html>
