<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->

    <div class="main-sidebar-header" >
     <a href="{{  route('dashboard') }}" class="header-logo" style="background-color: unset !important;" >
        <img src="{{ asset('images/brand-logos/invoice_genie_white.png') }}" alt="logo" class="desktop-logo">
        <img src="{{ asset('images/brand-logos/invoice_genie_black.png') }}" alt="logo" class="desktop-dark" style="margin-top: -7px;height: 36px;">
        <img src="{{ asset('images/brand-logos/invoice_genie_white.png') }}" alt="logo" class="desktop-white">
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
                <li class="slide {{ request()->routeIs('dashboard') ? 'active open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="bi bi-speedometer side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <li class="slide {{ request()->routeIs('businessmodels') || request()->routeIs('businessmodel.create') || request()->routeIs('businessmodel.edit') ? 'active open' : '' }}">
                    <a href="{{ route('businessmodels') }}" class="side-menu__item {{ request()->routeIs('businessmodels') || request()->routeIs('businessmodel.create') || request()->routeIs('businessmodel.edit') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-bar-chart side-menu__icon"></i>
                        <span class="side-menu__label">Business Models</span>
                    </a>
                </li>

                <li class="slide {{ request()->routeIs('connectedwebsites')  || request()->routeIs('site.connect.db') || request()->routeIs('product.selection') || request()->routeIs('search.result') || request()->routeIs('website.create') || request()->routeIs('website.edit')  ? 'active open' : '' }}">
                    <a href="{{ route('connectedwebsites') }}" class="side-menu__item {{ request()->routeIs('connectedwebsites') || request()->routeIs('site.connect.db') || request()->routeIs('product.selection') || request()->routeIs('search.result') || request()->routeIs('website.create') || request()->routeIs('website.edit') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-world side-menu__icon"></i>
                        <span class="side-menu__label">Available Websites</span>
                    </a>
                </li>

                <!-- Business Models -->
                <li class="slide__category"><span class="category-name">Models`s Websites</span></li>
                @foreach(getallModels() as $model)
                @php
                    $isActive = (request()->routeIs('businessmodel.websites') && request()->route('id') == $model->id);
                @endphp
                <li class="slide has-sub {{ $isActive ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ $isActive ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="{{ !empty($model->icon_class) ? $model->icon_class : 'ti-wallet' }} side-menu__icon"></i>
                        <span class="side-menu__label">{{ $model->name }}</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">{{ $model->name }}</a></li>
                        <li class="slide">
                            <a href="{{ route('businessmodel.websites', $model->id) }}" class="side-menu__item d-flex align-items-center justify-content-between {{ $isActive ? 'active' : '' }}">
                                <span>Available Websites</span>
                                <span class="badge bg-success">{{ getWebsiteCountByModel($model->id) }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endforeach

                @if(auth()->user()->roles->contains('name', 'admin'))
                <li class="slide__category"><span class="category-name">User Management</span></li>
                <li class="slide has-sub  {{ request()->routeIs('users.index') || request()->routeIs('users.create')  || request()->routeIs('users.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('users.index') || request()->routeIs('users.create')  || request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-user side-menu__icon"></i>
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

                <li class="slide has-sub {{ request()->routeIs('myprofile') || request()->routeIs('currency.index') || request()->routeIs('logout') || request()->routeIs('currency.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('myprofile') || request()->routeIs('currency.index') || request()->routeIs('logout') || request()->routeIs('currency.*') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-settings side-menu__icon"></i>
                        <span class="side-menu__label">Settings</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Settings</a></li>
                        <li class="slide"><a href="{{ route('myprofile') }}" class="side-menu__item">Profile</a></li>
                        <li class="slide"><a href="{{ route('currency.index') }}" class="side-menu__item">Currency</a></li>
                    </ul>
                </li>
                @elseif(auth()->user()->roles->contains('name', 'developer'))
                <li class="slide__category"><span class="category-name">User Management</span></li>
                <li class="slide has-sub  {{ request()->routeIs('users.index') || request()->routeIs('users.create')  || request()->routeIs('users.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('users.index') || request()->routeIs('users.create')  || request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-user side-menu__icon"></i>
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

                <li class="slide has-sub {{ request()->routeIs('myprofile') || request()->routeIs('currency.index') || request()->routeIs('logout') || request()->routeIs('currency.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item {{ request()->routeIs('myprofile') || request()->routeIs('currency.index') || request()->routeIs('logout') || request()->routeIs('currency.*') ? 'active' : '' }}">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-settings side-menu__icon"></i>
                        <span class="side-menu__label">Settings</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">Settings</a></li>
                        <li class="slide"><a href="{{ route('myprofile') }}" class="side-menu__item">Profile</a></li>
                        <li class="slide"><a href="{{ route('currency.index') }}" class="side-menu__item">Currency</a></li>
                        <li class="slide"><a href="{{ route('currency.manage.rates') }}" class="side-menu__item">Coversion Rate</a></li>
                    </ul>
                </li>
                @endif
               
               
            </ul>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
