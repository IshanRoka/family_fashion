@include('frontend.layouts.header')
<div class="hero">
    <div class="glide" id="glide_1">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <li class="glide__slide">
                    <div class="center">
                        <div class="left">
                            <a href="#" class="hero-btn">SHOP NOW</a>
                        </div>
                        <div class="right">
                            <img src="" alt="">
                        </div>
                    </div>
                </li>
                <li class="glide__slide">
                    <div class="center">
                        <div class="left">
                            <a href="#" class="hero-btn">SHOP NOW</a>
                        </div>
                        <div class="right">
                            <img src="" alt="">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</header>

<section class="section category">
    <div class="cat-center">
        @if (isset($prevPosts) && $prevPosts->count())
            @foreach ($prevPosts as $prevPost)
                <div class="cat">
                    <img src="{{ asset('storage/category/' . $prevPost->image) }}" alt="{{ $prevPost->name }}"
                        class="_image" height="160px" width="160px" />
                    <div>
                        <p>{{ $prevPost->name }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>No Category Available.</p>
        @endif
    </div>
</section>

<!-- New Arrivals -->
<section class="section new-arrival">
    <div class="title">
        <h1>NEW ARRIVALS</h1>
        <p>All the latest picked from designer of our store</p>
    </div>

    <div class="product-center">
        @foreach ($products as $product)
            <div class="product-item">
                <div class="overlay">
                    <a href="{{ route('frontend.productDetails', ['id' => $product->id]) }}" class="product-thumb">
                        <img src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" />
                    </a>
                </div>
                <div class="product-info">
                    <span>{{ $product->category_name->name }}</span>
                    <a href="{{ route('frontend.productDetails', ['id' => $product->id]) }}">{{ $product->name }}</a>
                    <h4>Rs {{ number_format($product->price, 2) }}</h4>
                </div>
            </div>
        @endforeach
    </div>

</section>

@include('frontend.layouts.footer')
