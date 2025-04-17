<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->

    <div class="main-sidebar-header">
     <a href="{{  route('dashboard') }}" class="header-logo">
        <img src="{{ asset('images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
        <img src="{{ asset('images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
        <img src="{{ asset('images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
        <img src="{{ asset('images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
        <img src="{{ asset('images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
        <img src="{{ asset('images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a> 
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

       <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <ul class="main-menu">
                <!-- Dashboard -->
                <li class="slide__category"><span class="category-name">Dashboard</span></li>
                <li class="slide">
                    <a href="{{ route('dashboard') }}" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-home side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-world side-menu__icon"></i>
                        <span class="side-menu__label">Models & Websites</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Models & Websites</a></li>
                        <li class="slide">
                            <a href="{{ route('businessmodels') }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                <span>Business Models</span>
                                <span class="badge bg-success">{{ getModelsCount() }}</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('connectedwebsites') }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                <span>Available Websites</span>
                                <span class="badge bg-success">{{ getAllWebsites() }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Business Models -->
                <li class="slide__category"><span class="category-name">Business Models</span></li>
                <?php $models = getallModels(); ?>
                @foreach($models as $model)
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <span class="shape1"></span>
                            <span class="shape2"></span>
                            <i class="{{ !empty($model->icon_class) ? $model->icon_class : 'ti-wallet' }} side-menu__icon"></i>
                            <span class="side-menu__label">{{ $model->name }}</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1"><a href="javascript:void(0)">{{ $model->name }}</a></li>
                            <li class="slide">
                                <a href="{{ route('businessmodel.websites', $model->id) }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                    <span>Connected Sites</span>
                                    <span class="badge bg-success">{{ getWebsiteCountByModel($model->id) }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endforeach

                <!-- User Management -->
                <li class="slide__category"><span class="category-name">User Management</span></li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="fe fe-users side-menu__icon"></i>
                        <span class="side-menu__label">Users</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 mega-menu">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Users</a></li>
                        <li class="slide">
                            <a href="{{ route('users.index') }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                <span>User List</span>
                                <span class="badge bg-success">{{ userCount() }}</span>
                            </a>
                        </li>
                        <li class="slide"><a href="{{ route('users.create') }}" class="side-menu__item">Add User</a></li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="fe fe-settings side-menu__icon"></i>
                        <span class="side-menu__label">Settings</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Settings</a></li>
                        <li class="slide"><a href="profile-settings.html" class="side-menu__item">Profile</a></li>
                        <li class="slide"><a href="{{ route('currency.index') }}" class="side-menu__item">Currency</a></li>
                        <li class="slide"><a href="{{ route('logout') }}" class="side-menu__item">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->