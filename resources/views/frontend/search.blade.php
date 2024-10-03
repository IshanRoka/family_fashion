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
        {{-- <h1>Search Results for "{{ $searchTerm }}"</h1> --}}

        <div class="product-list">
            @if (empty($products))
                <p>No products found.</p>
            @else
                @foreach ($products as $product)
                    <div class="product-item">
                        <div class="overlay">
                            <a href="{{ route('product.details', $product['id']) }}" class="product-thumb">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" />
                            </a>
                            @if (isset($product['discount']))
                                <!-- Check if discount exists -->
                                <span class="discount">{{ $product['discount'] }}%</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <span>{{ $product['category'] }}</span> <!-- Access category -->
                            <a href="{{ route('product.details', $product['id']) }}">{{ $product['name'] }}</a>
                            <h4>${{ $product['price'] }}</h4>
                        </div>
                    </div>
                @endforeach
            @endif
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
