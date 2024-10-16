@include('frontend.layouts.header')
<div class="container">
    <div class="login-form">
        <form id="loginCheck" method="post" action="{{ route('logincheck') }}">
            @csrf
            <h1>Login</h1>
            <p>
                Already have an account? Login in or
                <a href="{{ route('frontend.signup') }}">Sign Up</a>
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email" name="email" required />

            <label for="password">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required />

            <p>
                By creating an account you agree to our
                <a href="#">Terms & Privacy</a>.
            </p>

            <div class="buttons">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Login</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        $('#loginCheck').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '{{ route('logincheck') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#loginCheck')[0].reset();
                    showSuccessMessage(response.message);
                },
                error: function(xhr, status, error) {
                    showSuccessMessage('Invalid Email or password', xhr.responseJSON
                        .message);
                }
            });
        });
    });
</script> --}}
@include('frontend.layouts.footer')
