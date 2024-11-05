@include('frontend.layouts.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    html,
    body {
        position: relative;
        height: 100%;
    }

    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
    }

    .swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

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

    .btn {
        margin: 0.5rem 0;

    }

    #addCartBtn {
        margin-top: -2rem;
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
        max-height: 300px;
        overflow-y: auto;
        width: 70%;
        background: white;
        display: flex;
        align-items: center;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        padding: 1rem;
        margin: 1rem 0 3rem 0;
        flex-direction: column;
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

    .deatails,
    .qa {
        border-bottom: 1px solid black;
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
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.6rem;
        font-weight: 600;
        gap: 1rem;
        border-bottom: 1px solid black;
        padding: 0 0 1rem 0;
    }

    .questions,
    .answers {
        display: flex;
        align-items: center;
        gap: 3rem;
        margin: 1rem 0;
        width: 100%;
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

    #sortingOptions {
        padding: 1rem 2rem;
    }

    form {
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction: row;
        height: 3rem;
        margin: 3rem 0;
    }

    .login,
    .signup {
        color: green;
    }

    textarea {
        width: 90%;
        padding: 1rem 1.4rem;
        resize: none;
        border-top-left-radius: 1rem;
        border-bottom-left-radius: 1rem;
    }

    .ask {
        background-color: green;
        width: 10%;
        padding: 1rem 1.4rem;
        color: white;
        border-top-right-radius: 1rem;
        border-bottom-right-radius: 1rem;
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

                    <button type="submit" id="orderNow" class="orderNow btn">Order
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



{{-- <section class="section featured">
    <h1 style="text-align: center; margin-bottom: 1rem;">Reommended Products</h1>
    <div class="top container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($recommendedProducts as $recommendedProducts)
                    <div class="swiper-slide">
                        <img style="height: 400px;" src="{{ asset('storage/product/' . $recommendedProducts->image) }}"
                            alt="{{ $recommendedProducts->name }}" />
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section> --}}

<section class="review-section">

    <div class="main">
        <div class="heading">
            <h2>Review and Rating of xyz</h2>
            <h2>Average Rating: {{ number_format($averageRating, 2) }}/5</h2>
            <p>Total Rating:{{ $totalRating }}</p>
            <div class="sort">
                <div class="name">
                    Product Review
                </div>
                <div class="filter">
                    <form>
                        <select id="sortingOptions">
                            <option value="default">Default Sorting</option>
                            <option value="rating">Sort By Rating</option>
                        </select>
                    </form>
                </div>
            </div>
            @foreach ($order as $order)
                <div class="deatails">
                    <div class="date">
                        <div class="rating">{{ number_format($order->rating, 2) }}/5</div>
                        <div class="time">{{ $order->order_dates }}</div>
                    </div>
                    <div class="username">{{ $order->username }}<span>(Verified Purchase)</span></div>
                    <div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Nesciunt, dicta.
                    </div>
                    <div class="img"><img src="{{ asset('front/assets/images/product-1.jpg') }}" alt="">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="main">
        <div class="heading">
            <h2>Question about this product(Total Question)</h2>
            @if (!Auth::check())
                <div class="loginAndSignup">
                    <a href="{{ route('frontend.login') }}" class="login">Login</a>
                    <span>or</span>
                    <a href="{{ route('frontend.signup') }}" class="signup">Sign Up</a>
                    <span>(To ask question about the product)</span>
                </div>
            @endif
            @if (Auth::check())
                <div class="askQuestion">
                    <form>
                        @csrf
                        <textarea name="question" id=""></textarea>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <button class="ask" type="submit">Ask Question</button>
                    </form>
                </div>
            @endif
            @foreach ($question as $question)
                <div class="qa">
                    <div class="questions">
                        <div class="logo"><i class="fa-solid fa-question"></i></div>
                        <div class="question">
                            <div class="q">{{ $question->question }}</div>
                            <div class="u">
                                <p class="usernames">{{ $question->userDetails->username }}</p>
                                <div class="d">{{ $question->created_at }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="answers">
                        <div class="logo"><i class="fa-regular fa-comment"></i></div>
                        <div class="answer">
                            <div class="a">{{ $question->answer }}</div>

                            @if ($question->adminDetails && $question->adminDetails->username)
                                <div class="admin">{{ $question->adminDetails->username }}</div>
                            @else
                                <div class="admin">No reply</div>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@include('frontend.layouts.footer')
<script src="./js/index.js"></script>

<script src="./js/zoomsl.min.js"></script>
<script>
    document.getElementById('sortingOptions').addEventListener('change', function() {
        const selectedValue = this.value;
        if (selectedValue === 'rating') {
            window.location.href = '{{ route('product.rating') }}';
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


        $('.ask').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const formData = new FormData(form[0]);
            Swal.fire({
                title: 'Confirm Order',
                text: 'Do you want to ask question?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ask question!',
            }).then((result) => {
                if (result.isConfirmed) {

                    $('.loader').show();
                    $('.overlay').show();
                    $.ajax({
                        url: '{{ route('question.save') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            showSuccessMessage('Question send successfully')
                        },
                        error: function(xhr) {
                            showErrorMessage(
                                'Error questioning the product: ' + (xhr
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
