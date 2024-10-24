@include('frontend.layouts.header')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .orderNow,
    #addCartBtn {
        background: #6cbe02;
        color: white;
        border-radius: 1rem;
        padding: 0.7rem 0.4rem;
        width: 40%;
        text-align: center;
    }

    #addCartBtn {
        margin-top: 1rem;
    }

    #orderNow {
        margin-top: -2rem;
    }

    .review-section {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .main {
        width: 70%;
        background: white;
        display: flex;
        align-items: center;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        padding: 1rem;
        margin: 1rem 0 3rem 0;
    }

    .heading {
        width: 100%;
        border-bottom: 1px solid brown;
    }

    .heading h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
        text-align: center;
    }



    .sort,
    .date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1rem 0;
    }

    .username,
    .description,
    .img {
        margin-bottom: 1rem;
    }

    .username span {
        color: green;
        font-weight: 600;
    }

    .img img {
        width: 50px;
    }

    .loginAndSignup {
        border-bottom: 1px solid black;
        margin: 1rem 0;
    }

    .questions,
    .answers {
        display: flex;
        align-items: center;
        gap: 3rem;
        margin: 1rem 0;
    }

    .question,
    .answer {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem
    }

    .u {
        display: flex;
        gap: 5rem;
        align-items: center;
        justify-content: space-between;
    }
</style>
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
                    <input id="qty" style="width: 70px" type="hidden" name="quantity" placeholder="Quantity"
                        min="1" value="1" required />
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">
                    <input type="hidden" name="available_qty"
                        value=" {{ $product->stock_quantity - $product->orderDetails->sum('qty') }}">
                    <br>
                    <input type="hidden" name="size" value="{{ $product->size }}">
                    <input type="hidden" name="image" value="{{ $product->image }}">

                    <button type="submit" id="addCartBtn" class="addCart">Add To Cart</button>
                </form>
                <form id="orderNow">
                    @csrf
                    <input id="qty" style="width: 70px" type="hidden" name="quantity" placeholder="Quantity"
                        min="1" value="1" required />
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" name="total_price" value="{{ $product->price }}">
                    <input type="hidden" name="available_qty"
                        value=" {{ $product->stock_quantity - $product->orderDetails->sum('qty') }}">
                    <br>
                    <input type="hidden" name="size" value="{{ $product->size }}">
                    <input type="hidden" name="image" value="{{ $product->image }}">

                    <button type="submit" id="orderNow" class="orderNow">Order
                        Now</button>
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


<section class="review-section">
    <div class="main">
        <div class="heading">
            <h2>Review and Rating of xyz</h2>
            <h1>4.5/5</h1>
            <p>Total Rating:</p>
            <div class="sort">
                <div class="name">
                    Product Review
                </div>
                <div class="filter">
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
            </div>
            <div class="deatails">
                <div class="date">
                    <div class="rating">4.5/5</div>
                    <div class="time"><input type="date"></div>
                </div>
                <div class="username">Ishan Roka <span>(Verified Purchase)</span></div>
                <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt, dicta.
                </div>
                <div class="img"><img src="{{ asset('front/assets/images/product-1.jpg') }}" alt=""></div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="heading">
            <h2>Question about this product(Total Question)</h2>
            <div class="loginAndSignup">
                <a href="{{ route('frontend.login') }}">Login</a>
                <span>or</span>
                <a href="{{ route('frontend.signup') }}">Sign Up</a>
                <div class="questions">
                    <div class="logo"><i class="fa-solid fa-question"></i></div>
                    <div class="question">
                        <div class="q">Warrenty</div>
                        <div class="u">
                            <p class="usernames">Ishan Roka</p>
                            <div class="d">2024 </div>
                        </div>
                    </div>
                </div>
                <div class="answers">
                    <div class="logo"><i class="fa-regular fa-comment"></i></div>
                    <div class="answer">
                        <div class="a">1 years</div>
                        <div class="admin">Admin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.layouts.footer')
<script src="./js/index.js"></script>
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
    integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous">
</script>
<script src="./js/zoomsl.min.js"></script>
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
                    if (response.totalQuantity) {
                        $('.icon .d-flex').text(response.totalQuantity);
                    }
                },
                error: function(xhr) {
                    showSuccessMessage('Error adding product to cart: ' + xhr.responseJSON
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

    $(document).ready(function() {

        $('#orderNow').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const formData = new FormData(form[0]);
            Swal.fire({
                title: 'Confirm Order',
                text: 'Do you want to place this order?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, place order!',
            }).then((result) => {
                if (result.isConfirmed) {

                    $('.loader').show();
                    $('.overlay').show();
                    $.ajax({
                        url: '{{ route('order.save') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            window.location.href = '{{ route('order.confirm') }}';

                        },
                        error: function(xhr) {
                            showErrorMessage(
                                'Error ordering the product: ' + (xhr
                                    .responseJSON?.message || 'Unknown error')
                            );
                        },
                        complete: function() {
                            $('.loader').hide();
                            $('.overlay').hide();
                        },
                    });
                }
            });
        });

    });
</script>
</body>

</html>
