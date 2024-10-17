@include('frontend.layouts.secondHeader')
<style>
    p {
        margin: 2rem 0;
        font-size: 2rem;
    }

    .history {
        position: absolute;
        top: 10rem;
        right: 30rem;
        padding: 1rem 1.6rem;
        border: none;
        outline: none;
        cursor: pointer;
        background: rgb(143, 191, 89);
        border-radius: 0.5rem;
    }

    .history a {
        color: rgb(68, 44, 44);
        font-size: 1.6rem;
        font-weight: 500;
    }
</style>

<div class="containers"
    style="max-width: 600px; height: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">

    <h2 style="text-align: center; color: #333;">User Information</h2>
    <p><strong>Name:</strong> {{ Auth::user()->username }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    <p><strong>Phone Number:</strong> {{ Auth::user()->phone }}</p>
    <p><strong>Address:</strong> {{ Auth::user()->address }}</p>
    <button style="margin-top: 3rem; border-radius: 10px; background-color: red; padding: 0.6rem 1rem; border: none;"><a
            style="color: white; font-size: 1.8rem;" href="{{ route('logout') }}">Logout</a></button>
</div>

<form class="history" action="{{ route('order.history') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <button type="submit" class="btn btn-history">View History</button>
</form>

@include('frontend.layouts.footer')
<script>
    showSuccessMessage(response.message);
</script>
