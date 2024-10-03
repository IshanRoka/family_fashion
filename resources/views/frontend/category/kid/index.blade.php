@include('frontend.layouts.header')
<section class="section all-products" id="products">
    <div class="top container">
        <h1>All Products for Kids</h1>
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
        @foreach ($prevPosts as $prevPost)
            <div class="product-item">
                <div class="overlay">
                    <a href="{{ route('frontend.productDetails', ['id' => $prevPost->id]) }}" class="product-thumb">
                        <img src="{{ asset('storage/product/' . $prevPost->image) }}" alt="{{ $prevPost->name }}" />
                    </a>
                </div>
                <div class="product-info">
                    <span>{{ $prevPost->category_name->name }}</span>
                    <a href="{{ route('frontend.productDetails', ['id' => $prevPost->id]) }}">{{ $prevPost->name }}</a>
                    <h4>Rs {{ number_format($prevPost->price, 2) }}</h4>
                </div>
                {{-- <ul class="icons">
                    <li><i class="bx bx-heart"></i></li>
                    <li><i class="bx bx-search"></i></li>
                    <li><i class="bx bx-cart"></i></li>
                </ul> --}}
            </div>
        @endforeach
    </div>
</section>
@include('frontend.layouts.footer')