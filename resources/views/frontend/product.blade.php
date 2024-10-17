@include('frontend.layouts.header')
<section class="section all-products" id="products">
    <div class="top container">
        <h1>All Cloths</h1>
        <form>
            <select id="sortingOptions">
                <option value="default">Default Sorting</option>
                <option value="price">Sort By Price</option>
                <option value="sale">Sort By Sale</option>
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
        } else {
            window.location.href = '{{ route('product') }}';
        }
    });
</script>

@include('frontend.layouts.footer')
