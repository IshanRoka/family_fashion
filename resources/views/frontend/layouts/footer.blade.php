<style>
    .main-footer {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 10rem;
    }
</style>
<footer class="footer">
    <div class="row">
        <div class="col d-flex main-footer">
            <h4>Family Fashion</h4>
            <a href="{{ route('frontend.men') }}">Mens</a>
            <a href="{{ route('frontend.women') }}">Womens</a>
            <a href="{{ route('frontend.kid') }}">Kids</a>
        </div>
    </div>
</footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
<script src="{{ asset('front/assets/js/index.js') }}"></script>
<script src="{{ asset('front/assets/js/slider.js') }}"></script>

</html>
