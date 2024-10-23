    <!-- app-header -->
    <header class="app-header">

        <!-- Start::main-header-container -->
        <div class="main-header-container container-fluid" style="height: 4rem;">

            <!-- Start::header-content-left -->
            <div class="header-content-left">

                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="index.html" class="header-logo">
                            <img src="{{ asset('backpanel/assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                                class="desktop-logo">
                            <img src="{{ asset('backpanel/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                                class="toggle-logo">
                            <img src="{{ asset('backpanel/assets/images/brand-logos/desktop-white.png') }}"
                                alt="logo" class="desktop-white">
                            <img src="{{ asset('backpanel/assets/images/brand-logos/toggle-white.png') }}"
                                alt="logo" class="toggle-white">
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a aria-label="Hide Sidebar"
                        class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                        data-bs-toggle="sidebar" href="javascript:void(0);">
                        <i class="header-icon fe fe-align-left"></i>
                    </a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

                {{-- </div>@include('frontend.layouts.footer') --}}

                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->

                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

    </header>
    <!-- /app-header -->
