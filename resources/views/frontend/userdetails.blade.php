@include('frontend.layouts.header')
<style>
    p {
        margin: 2rem 0;
        font-size: 2rem;
    }
</style>

<div class="container"
    style="max-width: 600px; height: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">

    <h2 style="text-align: center; color: #333;">User Information</h2>
    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Phone Number:</strong> {{ Auth::user()->phone_number }}</p>
    <p><strong>Address:</strong> {{ Auth::user()->address }}</p>
    <button style="margin-top: 3rem; border-radius: 10px; background-color: red; padding: 0.6rem 1rem; border: none;"><a
            style="color: white; font-size: 1.8rem;" href="{{ route('logout') }}">Logout</a></button>
</div>


@include('frontend.layouts.footer')
