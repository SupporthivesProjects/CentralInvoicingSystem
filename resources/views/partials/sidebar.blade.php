<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('images/brand-logos/desktop-white.png') }}" class="desktop-white" alt="logo">
            <img src="{{ asset('images/brand-logos/toggle-white.png') }}" class="toggle-white" alt="logo">
            <img src="{{ asset('images/brand-logos/desktop-logo.png') }}" class="desktop-logo" alt="logo">
            <img src="{{ asset('images/brand-logos/toggle-dark.png') }}" class="toggle-dark" alt="logo">
            <img src="{{ asset('images/brand-logos/toggle-logo.png') }}" class="toggle-logo" alt="logo">
            <img src="{{ asset('images/brand-logos/desktop-dark.png') }}" class="desktop-dark" alt="logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Dashboard</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('dashboard') }}" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <!-- End::slide -->
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Business Models</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <!-- ECommerce -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-wallet side-menu__icon"></i>
                        <span class="side-menu__label">ECommerce</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">ECommerce</a></li>
                        <li class="slide"><a href="ecommerce-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="ecommerce-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Marketing -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-bar-chart side-menu__icon"></i>
                        <span class="side-menu__label">Marketing</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Marketing</a></li>
                        <li class="slide"><a href="marketing-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="marketing-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Gaming -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-game side-menu__icon"></i>
                        <span class="side-menu__label">Gaming</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Gaming</a></li>
                        <li class="slide"><a href="gaming-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="gaming-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Content Writing -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-pencil-alt side-menu__icon"></i>
                        <span class="side-menu__label">Content Writing</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Content Writing</a></li>
                        <li class="slide"><a href="content-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="content-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Image Gallery -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-image side-menu__icon"></i>
                        <span class="side-menu__label">Image Gallery</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Image Gallery</a></li>
                        <li class="slide"><a href="gallery-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="gallery-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Gift Card -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-gift side-menu__icon"></i>
                        <span class="side-menu__label">Gift Card</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Gift Card</a></li>
                        <li class="slide"><a href="giftcard-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide"><a href="giftcard-invoice-history.html" class="side-menu__item">View Invoice Records</a></li>
                    </ul>
                </li>

                <!-- Translation -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-flag-alt side-menu__icon"></i>
                        <span class="side-menu__label" data-i18n="translation">Translation</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)" data-i18n="translation">Translation</a></li>
                        <li class="slide"><a href="translation-create-invoice.html" class="side-menu__item" data-i18n="create_invoice">Generate Invoice</a></li>
                        <li class="slide"><a href="translation-invoice-history.html" class="side-menu__item" data-i18n="invoice_history">View Invoice Records</a></li>
                    </ul>
                </li>
                <!-- End::slide -->


                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">User Management</span></li>
                <!-- End::slide__category -->

               <!-- User Management -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="fe fe-users side-menu__icon"></i> <!-- updated icon -->
                        <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 mega-menu">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">User Management</a>
                        </li>
                        <li class="slide">
                            <a href="users-list.html" class="side-menu__item">User List</a> <!-- updated text -->
                        </li>
                        <li class="slide">
                            <a href="user-create.html" class="side-menu__item">Add New User</a> <!-- updated text -->
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="fe fe-settings side-menu__icon"></i> <!-- updated icon -->
                        <span class="side-menu__label">Settings</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Settings</a>
                        </li>
                        <li class="slide">
                            <a href="profile-settings.html" class="side-menu__item">Profile</a> <!-- updated text -->
                        </li>
                        <li class="slide">
                            <a href="{{ route('logout') }}" class="side-menu__item">Sign Out</a> <!-- updated text -->
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->