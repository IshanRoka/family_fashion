<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
    <link rel="stylesheet" href="{{ asset('backpanel/assets/c.css/style.css') }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


    <!-- Bootstrap JS        -->
    <script src="{{ asset('backpanel/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Show Password JS -->
    <script src="{{ asset('backpanel/assets/js/show-password.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.1.min.js"
        type="text/javascript"></script>
    <!-- Include jQuery Validation plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $('.alert').delay(3000).fadeOut();
    </script>
    <script>
        var baseurl = '{{ url(' / ') }}';
        var token = "<?= csrf_token() ?>";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function showLoader() {
            $('#loadingOverlay').show();
        }

        function hideLoader() {
            $('#loadingOverlay').hide();
        }

        function showNotification(message, type) {
            var notification = document.getElementById('customNotification');
            notification.textContent = message;

            if (type === 'success') {
                notification.style.backgroundColor = '#28a745'; // Green for success
            } else if (type === 'error') {
                notification.style.backgroundColor = '#dc3545'; // Red for error
            }

            // Show the notification
            notification.style.display = 'block';

            // Hide the notification after 3 seconds (adjust as needed)
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
        }
    </script>

</head>

<body>
    <nav>
        <div class="container nav_container">
            <a href="" class="nav_logo">
                <img src="assets/logo.png" alt="" />
            </a>
            <div class="nav_search">
                <i class="uil uil-search"></i>
                <input type="search" placeholder="Search" />
            </div>
            <div class="nav_profile-wrapper">
                <button class="nav_theme-btn">
                    <i class="uil uil-moon"></i>
                </button>
                <div class="nav_profile">
                    <div class="nav_profile-photo">
                        <img src="assets/profile-1.jpg" alt="" />
                    </div>
                    <h5 class="user">Ishan Roka</h5>
                    <i class="uil uil-angle-down"></i>
                </div>
                <button class="nav_menu-btn"><i class="uil uil-bars"></i></button>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="active">
            <i class="uil uil-create-dashboard"></i>
            <h5>Dashboard</h5>
        </a>
        <a href="{{ route('category') }}">
            <i class="uil uil-exchange"></i>
            <h5>Category</h5>
        </a>
        <a href="{{ route('product') }}">
            <i class="uil uil-wallet"></i>
            <h5>Product</h5>
        </a>
        <a href="{{ route('order.details') }}">
            <i class="uil uil-transaction"></i>
            <h5>Order</h5>
        </a>

        <button class="sidebar_close-btn">
            <i class="uil uil-times"></i>
        </button>
    </div>

    <main>
        <header class="main_header">
            <h1>Dashboard</h1>
        </header>
        <section class="main_cards">
            <article class="card">
                <div class="card_header">
                    <div class="card-header-left">
                        <h3>Total Category</h3>
                    </div>
                    <div class="card-header-right">
                        <img src="assets/visa.png" alt="" />
                    </div>
                </div>
                <div class="card_body">
                    <h1 class="dashboard">{{ !empty($totalCategory) ? $totalCategory : '0' }}</h1>
                    <div class="card-body-chip">
                        <img src="assets/card chip.png" alt="" />
                    </div>
                </div>

                <div class="card_footer">
                    <div class="card-footer-left">

                    </div>
                    <div class="card-footer-right">
                        <div class="expiry">

                        </div>
                        <div class="CVV">

                        </div>
                    </div>
                </div>
            </article>

            <article class="card">
                <div class="card_header">
                    <div class="card-header-left">
                        <h3>Total Product</h3>
                    </div>
                    <div class="card-header-right">
                        <img src="assets/visa.png" alt="" />
                    </div>
                </div>
                <div class="card_body">
                    <h1 class="dashboard">{{ !empty($totalProducts) ? $totalProducts : '0' }}</h1>
                    <div class="card-body-chip">
                        <img src="assets/card chip.png" alt="" />
                    </div>
                </div>

                <div class="card_footer">
                    <div class="card-footer-left">

                    </div>
                    <div class="card-footer-right">
                        <div class="expiry">

                        </div>
                        <div class="CVV">

                        </div>
                    </div>
                </div>
            </article>

            <article class="card">
                <div class="card_header">
                    <div class="card-header-left">
                        <h3>Total Customer</h3>
                    </div>
                    <div class="card-header-right">
                        <img src="assets/visa.png" alt="" />
                    </div>
                </div>
                <div class="card_body">
                    <h1 class="dashboard">{{ !empty($totalUser) ? $totalUser : '0' }}</h1>
                    <div class="card-body-chip">
                        <img src="assets/card chip.png" alt="" />
                    </div>
                </div>

                <div class="card_footer">
                    <div class="card-footer-left">

                    </div>
                    <div class="card-footer-right">
                        <div class="expiry">

                        </div>
                        <div class="CVV">

                        </div>
                    </div>
                </div>
            </article>
        </section>

        <section class="fastPayment">
            <h2>Fast Payment</h2>
            <ul class="fastPayment_badges">
                <li class="fastPayment_badge">
                    <span class="bg-primary"></span>
                    <div>
                        <h5>Traning</h5>
                        <h4>$90</h4>
                    </div>
                </li>

                <li class="fastPayment_badge">
                    <span class="bg-primary"></span>
                    <div>
                        <h5>Traning</h5>
                        <h4>$90</h4>
                    </div>
                </li>

                <li class="fastPayment_badge">
                    <span class="bg-primary"></span>
                    <div>
                        <h5>Traning</h5>
                        <h4>$90</h4>
                    </div>
                </li>

                <li class="fastPayment_badge">
                    <span class="bg-primary"></span>
                    <div>
                        <h5>Traning</h5>
                        <h4>$90</h4>
                    </div>
                </li>

                <li class="fastPayment_badge">
                    <span class="bg-danger"></span>
                    <div>
                        <h5>Traning</h5>
                        <h4>$90</h4>
                    </div>
                </li>
            </ul>
        </section>

        <canvas id="chart"></canvas>
    </main>

    <!-- Investment -->
    <section class="right">
        <section class="investments">
            <div class="investments_header">
                <h2>Investments</h2>
                <a href="">More</a>
            </div>

            <article class="investment">
                <img src="assets/uniliver.png" alt="" />
                <h4>Uniliver</h4>
                <div class="date-time">
                    <p>7 Nov, 2024</p>
                    <small class="text-muted">9:14 pm</small>
                </div>
                <div class="bond">
                    <p>1,234</p>
                    <small class="text-muted">Bounds</small>
                </div>
                <div class="amount">
                    <h5>$323,434</h5>
                    <small class="danger">-4,17%</small>
                </div>
            </article>

            <article class="investment">
                <img src="assets/uniliver.png" alt="" />
                <h4>Uniliver</h4>
                <div class="date-time">
                    <p>7 Nov, 2024</p>
                    <small class="text-muted">9:14 pm</small>
                </div>
                <div class="bond">
                    <p>1,234</p>
                    <small class="text-muted">Bounds</small>
                </div>
                <div class="amount">
                    <h5>$323,434</h5>
                    <small class="success">8.17%</small>
                </div>
            </article>

            <article class="investment">
                <img src="assets/uniliver.png" alt="" />
                <h4>Uniliver</h4>
                <div class="date-time">
                    <p>7 Nov, 2024</p>
                    <small class="text-muted">9:14 pm</small>
                </div>
                <div class="bond">
                    <p>1,234</p>
                    <small class="text-muted">Bounds</small>
                </div>
                <div class="amount">
                    <h5>$323,434</h5>
                    <small class="success">3.67%</small>
                </div>
            </article>

            <article class="investment">
                <img src="assets/uniliver.png" alt="" />
                <h4>Uniliver</h4>
                <div class="date-time">
                    <p>7 Nov, 2024</p>
                    <small class="text-muted">9:14 pm</small>
                </div>
                <div class="bond">
                    <p>1,234</p>
                    <small class="text-muted">Bounds</small>
                </div>
                <div class="amount">
                    <h5>$323,434</h5>
                    <small class="primary">0.17%</small>
                </div>
            </article>
        </section>

        <!-- Recent Transactions -->
        <setion class="recentTransactions">
            <header class="recentTransactions_header">
                <h2>Recent Transactions</h2>
                <a href="">More</a>
            </header>
            <article class="transaction">
                <div class="transaction_service">
                    <div class="icon bg-purple-light">Headphone</div>
                    <div class="transaction_details">
                        <h4>Music</h4>
                        <p>20.09.2024</p>
                    </div>
                </div>
                <div class="transaction_card-deatails">
                    <div class="transaction-card-image bg-danger">
                        <img src="assets/visa.png" alt="" />
                    </div>
                    <div class="transaction_details">
                        <p>*4342</p>
                        <small class="text-muted">Credit Card</small>
                    </div>
                </div>
                <h4>-$20</h4>
            </article>
            <article class="transaction">
                <div class="transaction_service">
                    <div class="icon bg-purple-light">Headphone</div>
                    <div class="transaction_details">
                        <h4>Music</h4>
                        <p>20.09.2024</p>
                    </div>
                </div>
                <div class="transaction_card-deatails">
                    <div class="transaction-card-image bg-danger">
                        <img src="assets/visa.png" alt="" />
                    </div>
                    <div class="transaction_details">
                        <p>*4342</p>
                        <small class="text-muted">Credit Card</small>
                    </div>
                </div>
                <h4>-$20</h4>
            </article>
            <article class="transaction">
                <div class="transaction_service">
                    <div class="icon bg-purple-light">Headphone</div>
                    <div class="transaction_details">
                        <h4>Music</h4>
                        <p>20.09.2024</p>
                    </div>
                </div>
                <div class="transaction_card-deatails">
                    <div class="transaction-card-image bg-danger">
                        <img src="assets/visa.png" alt="" />
                    </div>
                    <div class="transaction_details">
                        <p>*4342</p>
                        <small class="text-muted">Credit Card</small>
                    </div>
                </div>
                <h4>-$20</h4>
            </article>
            <article class="transaction">
                <div class="transaction_service">
                    <div class="icon bg-purple-light">Headphone</div>
                    <div class="transaction_details">
                        <h4>Music</h4>
                        <p>20.09.2024</p>
                    </div>
                </div>
                <div class="transaction_card-deatails">
                    <div class="transaction-card-image bg-danger">
                        <img src="assets/visa.png" alt="" />
                    </div>
                    <div class="transaction_details">
                        <p>*4342</p>
                        <small class="text-muted">Credit Card</small>
                    </div>
                </div>
                <h4>-$20</h4>
            </article>
            <article class="transaction">
                <div class="transaction_service">
                    <div class="icon bg-purple-light">Headphone</div>
                    <div class="transaction_details">
                        <h4>Music</h4>
                        <p>20.09.2024</p>
                    </div>
                </div>
                <div class="transaction_card-deatails">
                    <div class="transaction-card-image bg-danger">
                        <img src="assets/visa.png" alt="" />
                    </div>
                    <div class="transaction_details">
                        <p>*4342</p>
                        <small class="text-muted">Credit Card</small>
                    </div>
                </div>
                <h4>-$20</h4>
            </article>
        </setion>
    </section>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js"
    integrity="sha512-O2fWHvFel3xjQSi9FyzKXWLTvnom+lOYR/AUEThL/fbP4hv1Lo5LCFCGuTXBRyKC4K4DJldg5kxptkgXAzUpvA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('backpanel/assets/c.js/js.js') }}"></script>

</html>
