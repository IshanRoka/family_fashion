@include('frontend.layouts.header')
<div class="container">
    <div class="login-form">
        <form action="{{ route('signup') }}" method="POST">
            @csrf
            <h1>Sign Up</h1>
            <p>
                Please fill in this form to create an account or
                <a href="{{ route('frontend.login') }}">Login</a>
            </p>
            <label for="username">Username</label>
            <input type="text" placeholder="Enter username" name="username" required />

            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email" name="email" required />

            <label for="password">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required />

            <label for="phone">Phone number</label>
            <input type="text" placeholder="Enter phone number" name="phone" required />

            <label for="address">Address</label>
            <input type="text" placeholder="Enter address" name="address" required />

            <p>
                By creating an account you agree to our
                <a href="#">Terms & Privacy</a>.
            </p>

            <div class="buttons">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
            </div>
        </form>
    </div>
</div>
