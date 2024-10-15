@include('frontend.layouts.header')
<style>
    .check {
        border: none;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #6cbe02;
    }

    .product {
        margin-top: 2rem;
    }
</style>
<!-- Product Details -->
<section class="section product-detail">
    <div class="details container">
        <div class="left image-container">
            <div class="main">
                <img src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" />
            </div>
        </div>
        <div class="right">
            <h1>{{ $product->name }}</h1>
            <div class="price">Rs {{ $product->price }}</div>
            <br>
            <h4>Available Stock: {{ $product->stock_quantity - $product->orderDetails->sum('qty') }}</h4>
            <br>
            <h4>Available Size: {{ $product->size }}</h4>
            <br>
            <h4>Material Used: {{ $product->material }}</h4>
            <br>

            @auth
                {{-- <form class="form" style="margin-top: 1.4rem;">
                    @csrf
                    <input style="width: 70px" type="number" name="quantity" placeholder="" min="1"
                        max="{{ $product->stock_quantity }}" required />
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    <button type="submit" class="addCart">Add To Cart</button>
                </form> --}}
                <form class="form" id="addToCartForm">
                    @csrf
                    <input style="width: 70px" type="number" name="quantity" placeholder="Quantity" min="1"
                        value="1" required />
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">

                    <button type="submit" class="addCart">Add To Cart</button>
                </form>

                <!-- Cart Content Display -->
                <div id="cartItems">
                    <!-- Cart will be displayed here -->
                </div>

            @endauth
            @guest
                <a class="check" href="{{ route('frontend.login') }}" class="btn">Login to Order</a>
            @endguest
            <h3 class="product">Details</h3>
            <h4>
                {{ $product->description }}
            </h4>
        </div>
    </div>
</section>



{{-- <!-- Related -->
<section class="section featured">
    <div class="top container">
        <h1>Related Products</h1>
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
    </div>
</section> --}}
< @include('frontend.layouts.footer') <script src="./js/index.js"></script>
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
    integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous">
</script>
<script src="./js/zoomsl.min.js"></script>
<script>
    $(function() {
        console.log("hello");
        $("#zoom").imagezoomsl({
            zoomrange: [4, 4],
        });
    });

    $(document).ready(function() {
        $('#addToCartForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = $(this).serialize(); // Serialize the form data

            $.ajax({
                url: '{{ route('addToCart') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert(response.message); // Show success message

                    // Update cart UI with the new cart data
                    updateCartUI(response.cart);
                },
                error: function(xhr, status, error) {
                    console.error('Error adding product to cart:', xhr.responseJSON
                        .message);
                }
            });
        });

        function updateCartUI(cart) {
            let cartItems = $('#cartItems');
            cartItems.empty(); // Clear the previous cart content

            $.each(cart, function(key, item) {
                cartItems.append(`
                <div>
                    <p>${item.name} - ${item.quantity} x $${item.price}</p>
                    <form class="removeFromCartForm" data-product-id="${item.product_id}">
                        @csrf
                        <button type="submit">Remove</button>
                    </form>
                </div>
            `);
            });
        }

        // Handle remove from cart
        $(document).on('submit', '.removeFromCartForm', function(e) {
            e.preventDefault();

            let productId = $(this).data('product-id');

            $.ajax({
                url: '{{ route('removeFromCart') }}',
                type: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    product_id: productId
                },
                success: function(response) {
                    alert(response.message);

                    // Update cart UI with the new cart data
                    updateCartUI(response.cart);
                },
                error: function(xhr, status, error) {
                    console.error('Error removing product from cart:', xhr.responseJSON
                        .message);
                }
            });
        });
    });
</script>
</body>

</html>
