@include('frontend.layouts.header')
<style>
    button {
        border: none;
        border-radius: 1rem;
    }
    th {
        padding: 1rem;
    }
</style>
@auth
    <div class="container cart">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            @php
                $total = 0;
            @endphp

            @foreach ($cartItems as $item)
                <tr>
                    <td>
                        <div class="cart-info">
                            <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" height="30px" width="30px" />
                            <div>
                                <p>{{ $item['product_name'] }}</p>
                                <span>Price: Rs {{ number_format($item['price'] / $item['qty'], 2) }}</span>
                                <br />
                                {{-- <a href="{{ route('cart.remove', $item['id']) }}">remove</a> --}}
                                <!-- Assuming you have a route for removal -->
                            </div>
                        </div>
                    </td>
                    <td>
                        {{-- <form action="{{ route('cart.update', $item['id']) }}" method="POST"> --}}
                        <!-- Assuming you have a route for updating -->
                        @csrf
                        <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" />
                        <button type="submit">Update</button> <!-- Button to submit quantity change -->
                        {{-- </form> --}}
                    </td>
                    <td>Rs {{ number_format($item['price'], 2) }}</td>
                </tr>
                @php
                    $total += $item['price'];
                @endphp
            @endforeach
        </table>

        <div class="total-price">
            <table>
                <tr>
                    <td>Total</td>
                    <td>
                        <p>Total: Rs {{ number_format($total, 2) }}</p>
                    </td>
                </tr>
            </table>
            <form action="{{ route('order.save') }}" method="post" id="cart">
                @csrf
                <input type="hidden" name="cart_id" value="{{ $item['id'] }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <button type="submit" class="checkout btn">Order Now</button>
            </form>

        </div>
    </div>

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
@else
    <script>
        window.location.href = "{{ route('frontend.login') }}";
    </script>
@endauth

@include('frontend.layouts.footer')
