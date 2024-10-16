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
            <h4 id="stock-status">Available Stock: {{ $product->stock_quantity - $product->orderDetails->sum('qty') }}
            </h4>
            <br>
            <h4>Available Size: {{ $product->size }}</h4>
            <br>
            <h4>Material Used: {{ $product->material }}</h4>
            <br>

            @auth
                <form class="form" id="addToCartForm">
                    @csrf
                    <input id="qty" style="width: 70px" type="number" name="quantity" placeholder="Quantity"
                        min="1" value="1" required />
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <input type="hidden" name="available_qty"
                        value=" {{ $product->stock_quantity - $product->orderDetails->sum('qty') }}">
                    <input type="hidden" name="size" value="{{ $product->size }}">
                    <input type="hidden" name="image" value="{{ $product->image }}">

                    <button type="submit" id="addCartBtn" class="addCart">Add To Cart</button>
                </form>
                <p id="error-message" style="color: red; display: none;">
                    Requested quantity exceeds available stock.
                </p>
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
@include('frontend.layouts.footer')
<script src="./js/index.js"></script>
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
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ route('addToCart') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addToCartForm')[0].reset();
                    showSuccessMessage(response.message);
                },
                error: function(xhr, status, error) {
                    showSuccessMessage('Error adding product to cart:', xhr.responseJSON
                        .message);
                }
            });
        });
    });


    function updateStockStatus(stockQuantity, orderedQty) {
        const availableStock = stockQuantity - orderedQty;
        const stockStatusElement = document.getElementById('stock-status');
        const addToCartForm = document.getElementById('addToCartForm');

        if (availableStock <= 0) {
            stockStatusElement.innerText = 'Out of Stock';
            stockStatusElement.style.color = 'red';
            addToCartForm.style.display = 'none';
        } else {
            stockStatusElement.innerText = `Available Stock: ${availableStock}`;
            stockStatusElement.style.color = 'black';
        }
    }

    const stockQuantity = {{ $product->stock_quantity }};
    const orderedQty = {{ $product->orderDetails->sum('qty') }};

    updateStockStatus(stockQuantity, orderedQty);



    const qtyInput = document.getElementById('qty');
    const addCartBtn = document.getElementById('addCartBtn');
    const errorMessage = document.getElementById('error-message');
    const availableStock = {{ $product->stock_quantity - $product->orderDetails->sum('qty') }};
    qtyInput.addEventListener('input', function() {
        const requestedQuantity = parseInt(qtyInput.value);
        if (requestedQuantity > availableStock) {
            addCartBtn.disabled = true;
            errorMessage.style.display = 'block';
        } else {
            addCartBtn.disabled = false;
            errorMessage.style.display = 'none';
        }
    });
</script>
</body>

</html>
