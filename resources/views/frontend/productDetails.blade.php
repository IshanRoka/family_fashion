@include('frontend.layouts.header')

<!-- Product Details -->
<section class="section product-detail">
    <div class="details container">
        <div class="left image-container">
            <div class="main">
                <img src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" />
            </div>
        </div>
        <div class="right">
            <span>Category</span>
            <h1>{{ $product->name }}</h1>
            <div class="price">{{ $product->price }}</div>
            <br>
            <div class="size" style="">Available Size: {{ $product->size }}</div>
            <br>
            <form class="form" style="margin-top: 1.4rem;">
                <input type="text" placeholder="1" />
                <a href="cart.html" class="addCart">Add To Cart</a>
            </form>
            <h3>Product Detail</h3>
            <p>
                {{ $product->description }}
            </p>
        </div>
    </div>
</section>

<!-- Related -->
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
</section>
<!-- Footer -->
@include('frontend.layouts.footer')
<!-- Custom Script -->
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
</script>
</body>

</html>
