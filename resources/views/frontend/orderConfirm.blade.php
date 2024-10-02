@include('frontend.layouts.header')
<style>
    div.background {
        background: lightblue url('{{ asset('frontpanel/assets/images/bg.jpeg') }}') no-repeat center;
        background-size: cover;
        align-items: center;
        display: flex;
        justify-content: center;
        height: 500px;
        width: 100%;
    }

    div.transbox {
        background-color: rgba(255, 255, 255, 0.4);
        -webkit-backdrop-filter: blur(5px);
        backdrop-filter: blur(5px);
        padding: 20px;
        margin: 30px;
        font-weight: bold;
        border-radius: 1rem;
    }
</style>
<div class="background">
    <div class="transbox">
        <h1>Your order has been confirmed</h1>
    </div>
</div>
@include('frontend.layouts.footer')
