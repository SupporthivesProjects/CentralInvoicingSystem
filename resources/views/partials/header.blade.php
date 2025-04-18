 <!-- app-header -->
 <header class="app-header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                 <a href="{{  route('dashboard') }}" class="header-logo">
                        <img src="{{ asset('images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
                        <img src="{{ asset('images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
                        <img src="{{ asset('images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
                    </a> 
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="main-header-center d-none d-lg-block  header-link">
            <div class="input-group">
                <div class="input-group-btn search-panel">
                    <select class="js-example-basic-single" name="internalSearchType" id="internalSearchType" data-trigger>
                        <option value="websites">Websites</option>
                        <option value="business_models">Business Models</option>
                    </select>
                </div>
                <input type="text" class="form-control" data-url="{{ route('internal.search') }}" id="internalSearchInput" name="internalSearchInput" placeholder="Search for results..." autocomplete="off">
                <button class="btn btn-primary"><i class="fe fe-search" aria-hidden="true"></i></button>
            </div>
                <div id="searchspinner" class="text-center my-2" style="display: none;"></div>
                <div id="searchResults" class="header-search"></div>
            </div>
             <!-- End::header-element -->
             
        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">

            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                    <i class="fe fe-moon header-link-icon lh-2"></i>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                    <i class="fe fe-sun header-link-icon lh-2"></i>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element country-selector">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle country-Flag" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <circle cx="256" cy="256" r="256" fill="#f0f0f0" />
                            <g fill="#0052b4">
                                <path
                                    d="M52.92 100.142c-20.109 26.163-35.272 56.318-44.101 89.077h133.178L52.92 100.142zM503.181 189.219c-8.829-32.758-23.993-62.913-44.101-89.076l-89.075 89.076h133.176zM8.819 322.784c8.83 32.758 23.993 62.913 44.101 89.075l89.074-89.075H8.819zM411.858 52.921c-26.163-20.109-56.317-35.272-89.076-44.102v133.177l89.076-89.075zM100.142 459.079c26.163 20.109 56.318 35.272 89.076 44.102V370.005l-89.076 89.074zM189.217 8.819c-32.758 8.83-62.913 23.993-89.075 44.101l89.075 89.075V8.819zM322.783 503.181c32.758-8.83 62.913-23.993 89.075-44.101l-89.075-89.075v133.176zM370.005 322.784l89.075 89.076c20.108-26.162 35.272-56.318 44.101-89.076H370.005z" />
                            </g>
                            <g fill="#d80027">
                                <path
                                    d="M509.833 222.609H289.392V2.167A258.556 258.556 0 00256 0c-11.319 0-22.461.744-33.391 2.167v220.441H2.167A258.556 258.556 0 000 256c0 11.319.744 22.461 2.167 33.391h220.441v220.442a258.35 258.35 0 0066.783 0V289.392h220.442A258.533 258.533 0 00512 256c0-11.317-.744-22.461-2.167-33.391z" />
                                <path
                                    d="M322.783 322.784L437.019 437.02a256.636 256.636 0 0015.048-16.435l-97.802-97.802h-31.482v.001zM189.217 322.784h-.002L74.98 437.019a256.636 256.636 0 0016.435 15.048l97.802-97.804v-31.479zM189.217 189.219v-.002L74.981 74.98a256.636 256.636 0 00-15.048 16.435l97.803 97.803h31.481zM322.783 189.219L437.02 74.981a256.328 256.328 0 00-16.435-15.047l-97.802 97.803v31.482z" />
                            </g>
                        </svg>
                    </span>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    @foreach(currencies() as $currency)
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                            <span>{{ $currency->code }}</span> ({{$currency->symbol}})
                        </a>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element notifications-dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                    <i class="fe fe-bell header-link-icon"></i>
                    <span class="badge bg-secondary header-icon-badge pulse pulse-secondary" id="notification-icon-badge">5</span>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-17 fw-semibold">Notifications</p>
                            <span class="badge bg-secondary rounded-pill" id="notifiation-data">5 Unread</span>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled mb-0" id="header-notification-scroll">
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                 <div class="pe-2">
                                     <span class="avatar avatar-md online bg-primary-transparent br-5"><img alt="avatar" src="{{ asset('images/faces/5.jpg') }}"></span>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0"><a href="notifications-list.html" class="text-dark">Congratulate <strong>Olivia James</strong> for New template start</a></p>
                                        <span class="text-muted fw-normal fs-12 header-notification-text">Oct 15 12:32pm</span>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                 <div class="pe-2">
                                     <span class="avatar avatar-md offline bg-secondary-transparent br-5"><img alt="avatar" src="{{ asset('images/faces/2.jpg') }}"></span>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0"><a href="notifications-list.html" class="text-dark"><strong>Joshua Gray</strong> New Message Received</a></p>
                                        <span class="text-muted fw-normal fs-12 header-notification-text">Oct 13 02:56am</span>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                 <div class="pe-2">
                                     <span class="avatar avatar-md online bg-pink-transparent br-5"><img alt="avatar" src="{{ asset('images/faces/3.jpg') }}"></span>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0"><a href="notifications-list.html" class="text-dark"><strong>Elizabeth Lewis</strong> added new schedule realease</a></p>
                                        <span class="text-muted fw-normal fs-12 header-notification-text">Oct 12 10:40pm</span>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                 <div class="pe-2">
                                     <span class="avatar avatar-md online bg-warning-transparent br-5"><img alt="avatar" src="{{ asset('images/faces/5.jpg') }}"></span>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-normal"><a href="notifications-list.html" class="text-dark">Delivered Successful to <strong>Micky</strong> </a></p>
                                        <span class="text-muted fw-normal fs-12 header-notification-text">Order <span class="text-warning">ID: #005428</span> had been placed</span>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                            </div>
                        </li>
                        <li class="dropdown-item">
                            <div class="d-flex align-items-start">
                                 <div class="pe-2">
                                     <span class="avatar avatar-md offline bg-success-transparent br-5"><img alt="avatar" src="{{ asset('images/faces/1.jpg') }}"></span>
                                 </div>
                                 <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="mb-0 fw-normal"><a href="notifications-list.html" class="text-dark">You got 22 requests form <strong>Facebook</strong></a></p>
                                        <span class="text-muted fw-normal fs-12 header-notification-text">Today at 08:08pm</span>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-16"></i></a>
                                    </div>
                                 </div>
                            </div>
                        </li>
                    </ul>
                    <div class="p-3 empty-header-item1 border-top">
                        <div class="d-grid">
                            <a href="notifications-list.html" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="p-5 empty-item1 d-none">
                        <div class="text-center">
                            <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                <i class="ri-notification-off-line fs-2"></i>
                            </span>
                            <h6 class="fw-semibold mt-3">No New Notifications</h6>
                        </div>
                    </div>
                </div>
                <!-- End::main-header-dropdown -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element header-shortcuts-dropdown d-xl-flex d-none">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="notificationDropdown" aria-expanded="false">
                    <i class="fe fe-grid header-link-icon"></i>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <!-- Start::main-header-dropdown -->
                <div class="main-header-dropdown header-shortcuts-dropdown dropdown-menu pb-0 dropdown-menu-end" aria-labelledby="notificationDropdown">
                    <div class="p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 fs-17 fw-semibold">Business Models</p>
                        </div>
                    </div>
                    <div class="dropdown-divider mb-0"></div>
                    <div class="main-header-shortcuts p-2" id="header-shortcut-scroll">
                    <?php $businessmodels = getallModels(); ?>
                    
                       <div class="row g-2">
                       @foreach($businessmodels as $model)
                           <div class="col-4">
                               <a href="{{ route('businessmodel.websites', $model->id) }}" class="text-dark">
                                    <div class="text-center p-3 related-app">
                                        <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                        <i class="{{ !empty($model->icon_class) ? $model->icon_class : 'ti-wallet' }}  side-menu__icon"></i>
                                        </span>
                                        <span class="d-block fs-12">{{ $model->name }}</span>
                                    </div>
                                </a>
                           </div>
                          @endforeach
                       </div>
                    </div>
                    <div class="p-3 border-top">
                        <div class="d-grid">
                            <a href="{{ route('businessmodels') }}" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                </div>
                <!-- End::main-header-dropdown -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="header-link-icon">
                            <img src="{{ Auth::user()->profile->profile_image }}" alt="img" width="32" height="32" class="rounded-circle">
                        </div>
                        <div class="d-none">
                            <p class="fw-semibold mb-0">Angelica</p>
                            <span class="op-7 fw-normal d-block fs-11">Web Designer</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <Li>
                        <div class="header-navheading border-bottom">
                            <h6 class="main-notification-title">{{ Auth::user()->name }}</h6>
                            <p class="main-notification-text mb-0">{{ Auth::user()->profile->experience }}</p>
                        </div>
                    </Li>
                    <li><a class="dropdown-item d-flex border-bottom" href="{{ route('myprofile') }}"><i class="fe fe-user fs-16 align-middle me-2"></i>Profile</a></li>
                    {{-- <li><a class="dropdown-item d-flex border-bottom" href="mail-inbox.html"><i class="fe fe-inbox fs-16 align-middle me-2"></i>Inbox <span class="badge bg-success ms-auto">25</span></a></li>
                    <li><a class="dropdown-item d-flex border-bottom border-block-end" href="notifications-list.html"><i class="fe fe-compass fs-16 align-middle me-2"></i>Activity</a></li>
                    <li><a class="dropdown-item d-flex border-bottom" href="settings.html"><i class="fe fe-settings fs-16 align-middle me-2"></i>Settings</a></li>
                    <li><a class="dropdown-item d-flex border-bottom" href="chat.html"><i class="fe fe-headphones fs-16 align-middle me-2"></i>Support</a></li> --}}
                    <li><a class="dropdown-item d-flex" href="{{  route('logout')}}"><i class="fe fe-power fs-16 align-middle me-2"></i>Log Out</a></li>
                </ul>
            </div>
            <!-- End::header-element -->

           <style>
                #searchResults.active-search {
                    background-color: #ffffff !important;
                    padding: 20px !important;
                    border-radius: 8px !important;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
                    display: block !important;
                }
                
            </style>

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <i class="fe fe-settings header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->
</header>
<!-- /app-header -->