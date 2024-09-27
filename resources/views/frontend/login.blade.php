@include('frontend.layouts.header')
<div class="container">
    <div class="login-form">
        <form action="{{ route('logincheck') }}" method="POST">
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
@include('frontend.layouts.footer')
