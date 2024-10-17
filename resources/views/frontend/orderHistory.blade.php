@include('frontend.layouts.header')
<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .myHistory {
        margin: 2rem;
        width: 100%;
        height: 550px;
        outline: none;
        border-radius: 1rem;
        background: #fdfcfc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        overflow-y: auto;
        padding: 3rem;
    }

    h1 {
        font-size: 2rem;
        text-align: center;
        margin: 1rem 2rem;
    }
</style>
<main>
    <div class="myHistory">
        <h1>Order History</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Your Review</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sn = 1;
                @endphp
                @foreach ($historyDetails as $historyDetail)
                    <tr>
                        <td>{{ $sn++ }}</td>
                        <td>{{ $historyDetail->productDetails->name ?? 'Unknown Product' }}</td>
                        <td>
                            <img src="{{ asset('storage/product/' . $historyDetail->productDetails->image) }}"
                                alt="{{ $historyDetail->productDetails->name }}" />
                        </td>
                        <td>{{ $historyDetail->qty }}</td>
                        <td>
                            <span class="available_qty">
                                {{ $historyDetail->qty }}
                            </span>
                        </td>
                        <td>
                            <input style="border: none; width: 100px;" type="text" name="total_price" class="sub-total"
                                value="{{ number_format($historyDetail->total_price, 2) }}" readonly>
                        </td>
                        <td>
                            <input style="border: none; width: 100px;" type="text" name="total_price"
                                class="sub-total" value="{{ $historyDetail->status }}" readonly>
                        </td>
                        <td>
                            @if ($historyDetail->status != 'delivered')
                                <p style="font-size: 1.2rem">Product needs to be delivered for submitting review.</p>
                            @else
                                <form id="reviewForm">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $historyDetail->id }}">
                                    <input type="number" name="rating" min="1" max="5" step="0.5"
                                        value="{{ $historyDetail->rating }}" required>
                                    <button type="submit">Review</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if ($historyDetail->status == 'delivered' || $historyDetail->status == 'on_delivery')
                                <p style="font-size: 1.2rem">Cannot cancel product.</p>
                            @else
                                <form id="cancelOrderButton">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $historyDetail->id }}">
                                    <button type="submit">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#cancelOrderButton').click(function(e) {
            e.preventDefault();

            const form = $(this);
            let formData = form.serialize();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to cancel this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#FF0000',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('order.cancel') }}",
                        method: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Cancelled!',
                                    'The order has been cancelled.', ' success '
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!',
                                'Something went wrong. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            let formData = form.serialize();

            const rating = form.find('input[name="rating"]').val();
            if (rating < 1 || rating > 5) {
                Swal.fire('Invalid Rating', 'Rating must be between 1 and 5.',
                    'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to give a review to this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#FF0000',
                confirmButtonText: 'Yes, review it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('rating.save') }}",
                        method: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Success!', response.message, 'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            } else {
                                Swal.fire('Error!', 'Unable to submit review.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error!',
                                'Something went wrong. Please try again later.',
                                'error');
                        }
                    });
                }
            });
        });


    });
</script>
