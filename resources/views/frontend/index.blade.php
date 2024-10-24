@include('frontend.layouts.header')

<div class="hero">
    <h1>Cloth You might like</h1>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-1.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-2.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-3.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-4.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-5.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-6.jpg') }}" alt=""></div>
            <div class="swiper-slide"><img src="{{ asset('front/assets/images/product-7.jpg') }}" alt=""></div>
        </div>
        <div class="swiper-pagination"></div>
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
                    <p>Quantity Sold : {{ $product->orderDetails->sum('qty') }}</p>
                    <p>Rating:{{ number_format($product->orderDetails->avg('rating'), 2) }}/5</p>
                </div>
            </div>
        @endforeach
    </div>

</section>

@include('frontend.layouts.footer')
