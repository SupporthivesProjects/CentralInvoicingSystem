<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->

    <div class="main-sidebar-header">
        <a href="{{ route('dashboard') }}" class="header-logo text-white text-2xl font-bold">
            <span class="text-logo">Central Invoice System</span>
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
                <li class="slide__category"><span class="category-name">Connected Sites</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <!-- ECommerce -->
               <!-- Start::Sites Menu -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="ti-world side-menu__icon"></i> <!-- Updated icon -->
                        <span class="side-menu__label">Manage Sites</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Manage Sites</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('businessmodel.create') }}" class="side-menu__item">
                                Add Business Model
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('website.create') }}" class="side-menu__item">
                                Connect New Site
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('businessmodels') }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                <div>
                                    <span>Business models</span>
                                </div>
                                <span class="badge bg-success">{{ getModelsCount() }}</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('connectedwebsites') }}" class="side-menu__item d-flex align-items-center justify-content-between">
                                <div>
                                    <span>Connected Sites</span>
                                </div>
                                <span class="badge bg-success">{{ getAllWebsites() }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End::Sites Menu -->

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Business Models</span></li>
                <!-- End::slide__category -->
                 <!-- Start::slide -->

                <?php $models = getallModels(); ?>
                @foreach($models as $model)
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <span class="shape1"></span>
                        <span class="shape2"></span>
                        <i class="{{ !empty($model->icon_class) ? $model->icon_class : 'ti-wallet' }}  side-menu__icon"></i>
                        <span class="side-menu__label">{{ $model->name }} </span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1"><a href="javascript:void(0)">{{ $model->name }} </a></li>
                        <li class="slide"><a href="ecommerce-create-invoice.html" class="side-menu__item">Generate Invoice</a></li>
                        <li class="slide">
                            <a href="ecommerce-invoice-history.html" class="side-menu__item d-flex align-items-center justify-content-between">
                                <div>
                                    <span>Connected Sites</span>
                                </div>
                                <span class="badge bg-success">{{ getWebsiteCountByModel($model->id )}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endforeach

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
                            <a href="{{ route('users.index') }}" class="side-menu__item">User List</a> <!-- updated text -->
                            <span class="badge bg-success">{{ userCount() }}</span>
                        </li>
                        <li class="slide">
                            <a href="{{ route('users.create') }}" class="side-menu__item">Add New User</a> <!-- updated text -->
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