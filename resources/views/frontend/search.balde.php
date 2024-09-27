@include('frontend.layouts.header')
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
@include('frontend.layouts.footer')