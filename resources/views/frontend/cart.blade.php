@include('frontend.layouts.header')
<div class="container cart">
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>



        @foreach ($cartItems as $item)
            <tr>
                <td>
                    <div class="cart-info">
                        <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" height="30px" width="30px" />
                        <div>gre
                            <p>{{ $item->product_name }}</p>
                            <span>Price: ${{ number_format($item['price'], 2) }}</span> <br />
                            <a href="#">remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="{{ $item['qty'] }}" min="1" /></td>
                <td>${{ number_format($item['price'] * $item['qty'], 2) }}</td>
            </tr>

            @php
                $subtotal += $item['price'] * $item['qty'];
            @endphp
        @endforeach
    </table>

    <div class="total-price">
        <table>
            <tr>
                <td>Subtotal</td>
                <td>${{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                @php
                    $tax = $subtotal * 0.1; // Assuming 10% tax rate
                @endphp
                <td>Tax</td>
                <td>${{ number_format($tax, 2) }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>${{ number_format($subtotal + $tax, 2) }}</td>
            </tr>
        </table>
        <a href="#" class="checkout btn">Proceed To Checkout</a>
    </div>
</div>




<!-- Latest Products -->
<section class="section featured">
    <div class="top container">
        <h1>Latest Products</h1>
        <a href="#" class="view-more">View more</a>
    </div>
    <div class="product-center container">
        <div class="product-item">
            <div class="overlay">
                <a href="" class="product-thumb">
                    <img src="{{ asset('front/assets/images/product-1.jpg') }}" alt="" />
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
                    <img src="{{ asset('front/assets/images/product-1.jpg') }}" alt="" />
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
                    <img src="{{ asset('front/assets/images/product-1.jpg') }}" alt="" />
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
                    <img src="{{ asset('front/assets/images/product-1.jpg') }}" alt="" />
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
