@include('frontend.layouts.header')
<section class="section all-products" id="products">
    <div class="top container">
        <h1>All Cloths</h1>
        <form>
            <select id="sortingOptions">
                <option value="default">Default Sorting</option>
                <option value="price">Sort By Price</option>
                <option value="sale">Sort By Sale</option>
                <option value="rating">Sort By Rating</option>
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
                    <span>{{ $prevPost->category_name }}</span>
                    <a href="{{ route('frontend.productDetails', ['id' => $prevPost->id]) }}">{{ $prevPost->name }}</a>
                    <h4>Rs {{ number_format($prevPost->price, 2) }}</h4>
                    <p>Quantity Sold : {{ $prevPost->sold_qty }}</p>
                    <p>Rating: {{ number_format($prevPost->average_rating, 2) }}/5</p>

                </div>
            </div>
        @endforeach
    </div>
</section>
<script>
    document.getElementById('sortingOptions').addEventListener('change', function() {
        const selectedValue = this.value;
        if (selectedValue === 'price') {
            window.location.href = '{{ route('product.price') }}';
        } else if (selectedValue === 'sale') {
            window.location.href = '{{ route('product.sale') }}';
        } else if (selectedValue === 'rating') {
            window.location.href = '{{ route('product.rating') }}';
        } else {
            window.location.href = '{{ route('product') }}';
        }
    });
</script>

@include('frontend.layouts.footer')
