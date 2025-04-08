@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')


    <link rel="stylesheet" href="{{ asset('libs/jsvectormap/css/jsvectormap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/swiper/swiper-bundle.min.css') }}">

    <div class="page">
        <!-- app-header -->
        <header class="app-header">

           <!-- Start::main-header-container -->
           <div class="main-header-container container-fluid">

               <!-- Start::header-content-left -->
               <div class="header-content-left">

                   <!-- Start::header-element -->
                   <div class="header-element">
                       <div class="horizontal-logo">
                           <a href="index.html" class="header-logo">
                               <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                               <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                               <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                               <img src="../assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                               <img src="../assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
                               <img src="../assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
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
                               <select class="js-example-basic-single" name="state" data-trigger>
                                   <option value="s-1">Choose one</option>
                                   <option value="s-2">T-Projects...</option>
                                   <option value="s-3">Microsoft Project</option>
                                   <option value="s-4">Risk Management</option>
                                   <option value="s-5">Team Building</option>
                               </select>
                           </div>
                           <input type="text" class="form-control" id="typehead" placeholder="Search for results..."
                           autocomplete="off">
                       <button class="btn btn-primary"><i class="fe fe-search" aria-hidden="true"></i></button>
                       </div>
                       <div id="headersearch" class="header-search">
                           <div class="p-3">
                               <div class="">
                                   <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                                   <div class="ps-2">
                                       <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                                       <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                                       <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
                                   </div>
                               </div>
                                <div class="mt-3">
                                   <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                                   <ul class="ps-2 list-unstyled">
                                       <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                           <a href="full-calendar.html"><span><i class='bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Calendar</span></a>
                                       </li>
                                       <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                           <a href="mail-inbox.html"><span><i class='bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle'></i>Mail</span></a>
                                       </li>
                                       <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                           <a href="buttons.html"><span><i class='bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Buttons</span></a>
                                       </li>
                                   </ul>
                               </div>
                               <div class="mt-3">
                                  <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                                  <ul class="ps-2 list-unstyled">
                                       <li class="p-1 align-items-center text-muted mb-1 search-app">
                                               <a href="javascript:void(0)" class="text-primary"><u>http://spruko/html/spruko.com</u></a>
                                       </li>
                                       <li class="p-1 align-items-center text-muted mb-1 search-app">
                                               <a href="javascript:void(0)" class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
                                       </li>
                                   </ul>
                              </div>
                           </div>
                           <div class="py-3 border-top px-0">
                               <div class="text-center">
                                   <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all</a>
                               </div>
                           </div>
                       </div>
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
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/6.jpg" alt="img">
                                   </span>
                                   English
                               </a>
                           </li>
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/5.jpg" alt="img" >
                                   </span>
                                   Spanish
                               </a>
                           </li>
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/1.jpg" alt="img" >
                                   </span>
                                   French
                               </a>
                           </li>
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/2.jpg" alt="img" >
                                   </span>
                                   German
                               </a>
                           </li>
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/3.jpg" alt="img" >
                                   </span>
                                   Italian
                               </a>
                           </li>
                           <li>
                               <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                   <span class="avatar avatar-xs lh-1 me-2">
                                       <img src="../assets/images/flags/4.jpg" alt="img" >
                                   </span>
                                   Russian
                               </a>
                           </li>
                       </ul>
                   </div>
                   <!-- End::header-element -->

                   <!-- Start::header-element -->
                   <div class="header-element header-fullscreen  d-xl-flex d-none">
                       <!-- Start::header-link -->
                       <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                           <i class="fe fe-maximize full-screen-open header-link-icon"></i>
                           <i class="fe fe-minimize full-screen-close header-link-icon d-none"></i>
                       </a>
                       <!-- End::header-link -->
                   </div>
                   <!-- End::header-element -->

                   <!-- Start::header-element -->
                   <div class="header-element cart-dropdown d-xl-flex d-none">
                       <!-- Start::header-link|dropdown-toggle -->
                       <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                           <i class="fe fe-shopping-cart header-link-icon"></i>
                           <span class="badge bg-primary header-icon-badge" id="cart-icon-badge">5</span>
                       </a>
                       <!-- End::header-link|dropdown-toggle -->
                       <!-- Start::main-header-dropdown -->
                       <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                           <div class="p-3">
                               <div class="d-flex align-items-center justify-content-between">
                                   <p class="mb-0 fs-17 fw-semibold">Cart Items</p>
                                   <span class="badge bg-primary rounded-pill" id="cart-data">5 Items</span>
                               </div>
                           </div>
                           <div><hr class="dropdown-divider"></div>
                           <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                               <li class="dropdown-item">
                                   <div class="d-flex align-items-center cart-dropdown-item">
                                       <img src="../assets/images/ecommerce/jpg/1.jpg" alt="img" class="avatar avatar-sm br-5 me-3">
                                       <div class="flex-grow-1">
                                           <div class="d-flex align-items-start justify-content-between mb-0">
                                               <div class="mb-0 fs-13 text-dark fw-medium">
                                                   <a href="ecommerce-cart.html" class="text-dark">Smart Watch</a>
                                               </div>
                                               <div>
                                                   <span class="text-black mb-1 fw-medium">$1,299.00</span>
                                               </div>
                                           </div>
                                           <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                                               <ul class="header-product-item d-flex">
                                                   <li>Qty: 1</li>
                                                   <li>Status: <span class="text-success">In Stock</span></li>
                                               </ul>
                                               <div class="ms-auto">
                                                   <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ri-delete-bin-2-line"></i></a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </li>
                               <li class="dropdown-item">
                                   <div class="d-flex align-items-center cart-dropdown-item">
                                       <img src="../assets/images/ecommerce/jpg/3.jpg" alt="img" class="avatar avatar-sm br-5 me-3">
                                       <div class="flex-grow-1">
                                           <div class="d-flex align-items-start justify-content-between mb-0">
                                               <div class="mb-0 fs-13 text-dark fw-medium">
                                                   <a href="ecommerce-cart.html" class="text-dark">Flowers</a>
                                               </div>
                                               <div>
                                                   <span class="text-black mb-1 fw-medium">$179.29</span>
                                               </div>
                                           </div>
                                           <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                                               <ul class="header-product-item">
                                                   <li>Qty: 2</li>
                                                   <li><span class="badge bg-pink-transparent fs-10">Free shipping</span></li>
                                               </ul>
                                               <div class="ms-auto">
                                                   <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ri-delete-bin-2-line"></i></a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </li>
                               <li class="dropdown-item">
                                   <div class="d-flex align-items-center cart-dropdown-item">
                                       <img src="../assets/images/ecommerce/jpg/5.jpg" alt="img" class="avatar avatar-sm br-5 me-3">
                                       <div class="flex-grow-1">
                                           <div class="d-flex align-items-start justify-content-between mb-0">
                                               <div class="mb-0 fs-13 text-dark fw-medium">
                                                   <a href="ecommerce-cart.html" class="text-dark">Running Shoes</a>
                                               </div>
                                               <div>
                                                   <span class="text-black mb-1 fw-medium">$29.00</span>
                                               </div>
                                           </div>
                                           <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                                               <ul class="header-product-item d-flex">
                                                   <li>Qty: 4</li>
                                                   <li>Status: <span class="text-danger">Out Stock</span></li>
                                               </ul>
                                               <div class="ms-auto">
                                                   <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ri-delete-bin-2-line"></i></a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </li>
                               <li class="dropdown-item">
                                   <div class="d-flex align-items-center cart-dropdown-item">
                                       <img src="../assets/images/ecommerce/jpg/4.jpg" alt="img" class="avatar avatar-sm br-5 me-3">
                                       <div class="flex-grow-1">
                                           <div class="d-flex align-items-start justify-content-between mb-0">
                                               <div class="mb-0 fs-13 text-dark fw-medium">
                                                   <a href="ecommerce-cart.html" class="text-dark">Furniture</a>
                                               </div>
                                               <div>
                                                   <span class="text-black mb-1 fw-medium">$4,999.00</span>
                                               </div>
                                           </div>
                                           <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                                               <ul class="header-product-item d-flex">
                                                   <li>Gray</li>
                                                   <li>50LB</li>
                                               </ul>
                                               <div class="ms-auto">
                                                   <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ri-delete-bin-2-line"></i></a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </li>
                               <li class="dropdown-item">
                                   <div class="d-flex align-items-center cart-dropdown-item">
                                       <img src="../assets/images/ecommerce/jpg/6.jpg" alt="img" class="avatar avatar-sm br-5 me-3">
                                       <div class="flex-grow-1">
                                           <div class="d-flex align-items-start justify-content-between mb-0">
                                               <div class="mb-0 fs-13 text-dark fw-medium">
                                                   <a href="ecommerce-cart.html" class="text-dark">Tourist Bag</a>
                                               </div>
                                               <div>
                                                   <span class="text-black mb-1 fw-medium">$129.00</span>
                                               </div>
                                           </div>
                                           <div class="d-flex align-items-start justify-content-between">
                                               <ul class="header-product-item d-flex">
                                                   <li>Qty: 1</li>
                                                   <li>Status: <span class="text-success">In Stock</span></li>
                                               </ul>
                                               <div class="ms-auto">
                                                   <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ri-delete-bin-2-line"></i></a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </li>
                           </ul>
                           <div class="p-3 empty-header-item border-top">
                               <div class="d-grid">
                                   <a href="ecommerce-checkout.html" class="btn btn-primary">Proceed to checkout</a>
                               </div>
                           </div>
                           <div class="p-5 empty-item d-none">
                               <div class="text-center">
                                   <span class="avatar avatar-xl avatar-rounded bg-warning-transparent">
                                       <i class="ri-shopping-cart-2-line fs-2"></i>
                                   </span>
                                   <h6 class="fw-bold mb-1 mt-3">Your Cart is Empty</h6>
                                   <span class="mb-3 fw-normal fs-13 d-block">Add some items to make me happy :)</span>
                                   <a href="ecommerce-products.html" class="btn btn-primary btn-wave btn-sm m-1" data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
                               </div>
                           </div>
                       </div>
                       <!-- End::main-header-dropdown -->
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
                                            <span class="avatar avatar-md online bg-primary-transparent br-5"><img alt="avatar" src="../assets/images/faces/5.jpg"></span>
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
                                            <span class="avatar avatar-md offline bg-secondary-transparent br-5"><img alt="avatar" src="../assets/images/faces/2.jpg"></span>
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
                                            <span class="avatar avatar-md online bg-pink-transparent br-5"><img alt="avatar" src="../assets/images/faces/3.jpg"></span>
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
                                            <span class="avatar avatar-md online bg-warning-transparent br-5"><img alt="avatar" src="../assets/images/faces/5.jpg"></span>
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
                                            <span class="avatar avatar-md offline bg-success-transparent br-5"><img alt="avatar" src="../assets/images/faces/1.jpg"></span>
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
                                   <p class="mb-0 fs-17 fw-semibold">Related Apps</p>
                               </div>
                           </div>
                           <div class="dropdown-divider mb-0"></div>
                           <div class="main-header-shortcuts p-2" id="header-shortcut-scroll">
                              <div class="row g-2">
                                  <div class="col-4">
                                      <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/figma.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Figma</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/microsoft-powerpoint.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Power Point</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/microsoft-word.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">MS Word</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/calender.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Calendar</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/sketch.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Sketch</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/google-docs.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Docs</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/google.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Google</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/translate.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Translate</span>
                                           </div>
                                       </a>
                                  </div>
                                  <div class="col-4">
                                       <a href="javascript:void(0);" class="text-dark">
                                           <div class="text-center p-3 related-app">
                                               <span class="avatar avatar-sm rounded-2 p-1 bg-primary-transparent">
                                                   <img src="../assets/images/apps/google-sheets.png" alt="">
                                               </span>
                                               <span class="d-block fs-12">Sheets</span>
                                           </div>
                                       </a>
                                  </div>
                              </div>
                           </div>
                           <div class="p-3 border-top">
                               <div class="d-grid">
                                   <a href="javascript:void(0);" class="btn btn-primary">View All</a>
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
                                   <img src="../assets/images/faces/1.jpg" alt="img" width="32" height="32" class="rounded-circle">
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
                                   <h6 class="main-notification-title">Sonia Taylor</h6>
                                   <p class="main-notification-text mb-0">Web Designer</p>
                               </div>
                           </Li>
                           <li><a class="dropdown-item d-flex border-bottom" href="profile.html"><i class="fe fe-user fs-16 align-middle me-2"></i>Profile</a></li>
                           <li><a class="dropdown-item d-flex border-bottom" href="mail-inbox.html"><i class="fe fe-inbox fs-16 align-middle me-2"></i>Inbox <span class="badge bg-success ms-auto">25</span></a></li>
                           <li><a class="dropdown-item d-flex border-bottom border-block-end" href="notifications-list.html"><i class="fe fe-compass fs-16 align-middle me-2"></i>Activity</a></li>
                           <li><a class="dropdown-item d-flex border-bottom" href="settings.html"><i class="fe fe-settings fs-16 align-middle me-2"></i>Settings</a></li>
                           <li><a class="dropdown-item d-flex border-bottom" href="chat.html"><i class="fe fe-headphones fs-16 align-middle me-2"></i>Support</a></li>
                           <li><a class="dropdown-item d-flex" href="signin.html"><i class="fe fe-power fs-16 align-middle me-2"></i>Log Out</a></li>
                       </ul>
                   </div>
                   <!-- End::header-element -->

                   <!-- Start::header-element -->
                   <div class="header-element right-sidebar d-xl-flex d-none">
                       <a href="javascript:void(0);" class="header-link right-sidebar" data-bs-toggle="offcanvas" data-bs-target="#right-sidebar-canvas">
                           <i class="fe fe-align-right header-icons header-link-icon"></i>
                       </a>
                   </div>
                   <!-- End::header-element -->

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
       <!-- Start::app-sidebar -->
       <aside class="app-sidebar sticky" id="sidebar">

           <!-- Start::main-sidebar-header -->
           <div class="main-sidebar-header">
               <a href="index.html" class="header-logo">
                   <img src="../assets/images/brand-logos/desktop-white.png" class="desktop-white" alt="logo">
                   <img src="../assets/images/brand-logos/toggle-white.png" class="toggle-white" alt="logo">
                   <img src="../assets/images/brand-logos/desktop-logo.png" class="desktop-logo" alt="logo">
                   <img src="../assets/images/brand-logos/toggle-dark.png" class="toggle-dark" alt="logo">
                   <img src="../assets/images/brand-logos/toggle-logo.png" class="toggle-logo" alt="logo">
                   <img src="../assets/images/brand-logos/desktop-dark.png" class="desktop-dark" alt="logo">
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
                           <a href="index.html" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-home side-menu__icon"></i>
                               <span class="side-menu__label">Dashboard</span>
                           </a>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-wallet side-menu__icon"></i>
                               <span class="side-menu__label">Crypto Currencies</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Crypto Currencies</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-dashboard.html" class="side-menu__item">Dashboard</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-market.html" class="side-menu__item">Marketcap</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-currency-exchange.html" class="side-menu__item">Currency exchange</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-buy-sell.html" class="side-menu__item">Buy & Sell</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-wallet.html" class="side-menu__item">Wallet</a>
                               </li>
                               <li class="slide">
                                   <a href="crypto-transactions.html" class="side-menu__item">Transactions</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-shopping-cart-full side-menu__icon"></i>
                               <span class="side-menu__label">ECommerce</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">E-Commerce</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-dashboard.html" class="side-menu__item">Dashboard</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-products.html" class="side-menu__item">Products</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-product-details.html" class="side-menu__item">Product Details</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-cart.html" class="side-menu__item">Cart</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-wishlist.html" class="side-menu__item">Wishlist</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-checkout.html" class="side-menu__item">Checkout</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-orders.html" class="side-menu__item">Orders</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-add-product.html" class="side-menu__item">Add Product</a>
                               </li>
                               <li class="slide">
                                   <a href="ecommerce-account.html" class="side-menu__item">Account</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide__category -->
                       <li class="slide__category"><span class="category-name">Landing</span></li>
                       <!-- End::slide__category -->

                       <!-- Start::slide -->
                       <li class="slide">
                           <a href="landing.html" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-layout side-menu__icon"></i>
                               <span class="side-menu__label">Landing Page</span>
                           </a>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide__category -->
                       <li class="slide__category"><span class="category-name">Applications</span></li>
                       <!-- End::slide__category -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-write side-menu__icon"></i>
                               <span class="side-menu__label">Apps</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Apps</a>
                               </li>
                               <li class="slide">
                                   <a href="widgets.html" class="side-menu__item">Widgets</a>
                               </li>
                               <li class="slide">
                                   <a href="sweet_alerts.html" class="side-menu__item">Sweet Alerts</a>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Mail<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="mail-inbox.html" class="side-menu__item">Mail-Inbox</a>
                                       </li>
                                       <li class="slide">
                                           <a href="viewmail.html" class="side-menu__item">View-Mail</a>
                                       </li>
                                       <li class="slide">
                                           <a href="mail-compose.html" class="side-menu__item">Mail-Compose</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Maps<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="leaflet-maps.html" class="side-menu__item">Leaflet Maps</a>
                                       </li>
                                       <li class="slide">
                                           <a href="vector-maps.html" class="side-menu__item">Vector Maps</a>
                                       </li>
                                       <li class="slide">
                                           <a href="google-maps.html" class="side-menu__item">Google Maps</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Tables<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="tables.html" class="side-menu__item">Tables</a>
                                       </li>
                                       <li class="slide">
                                           <a href="grid-tables.html" class="side-menu__item">Grid JS Tables</a>
                                       </li>
                                       <li class="slide">
                                           <a href="data-tables.html" class="side-menu__item">Data Tables</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Blog<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="blog.html" class="side-menu__item">Blog Page</a>
                                       </li>
                                       <li class="slide">
                                           <a href="blog-details.html" class="side-menu__item">Blog Details</a>
                                       </li>
                                       <li class="slide">
                                           <a href="blog-post.html" class="side-menu__item">Blog Post</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">File Manager<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="file-manager.html" class="side-menu__item">File Manager</a>
                                       </li>
                                       <li class="slide">
                                           <a href="file-manager-list.html" class="side-menu__item">File Manager List</a>
                                       </li>
                                       <li class="slide">
                                           <a href="file-details.html" class="side-menu__item">File Details</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide">
                                   <a href="icons.html" class="side-menu__item">Icons</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide__category -->
                       <li class="slide__category"><span class="category-name">Components</span></li>
                       <!-- End::slide__category -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-package side-menu__icon"></i>
                               <span class="side-menu__label">Elements</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1 mega-menu">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Elements</a>
                               </li>
                               <li class="slide">
                                   <a href="accordions_collpase.html" class="side-menu__item">Accordions & Collapse</a>
                               </li>
                               <li class="slide">
                                   <a href="alerts.html" class="side-menu__item">Alerts</a>
                               </li>
                               <li class="slide">
                                   <a href="avatars.html" class="side-menu__item">Avatars</a>
                               </li>
                               <li class="slide">
                                   <a href="breadcrumb.html" class="side-menu__item">Breadcrumbs</a>
                               </li>
                               <li class="slide">
                                   <a href="buttons.html" class="side-menu__item">Buttons</a>
                               </li>
                               <li class="slide">
                                   <a href="buttongroup.html" class="side-menu__item">Button Group</a>
                               </li>
                               <li class="slide">
                                   <a href="badge.html" class="side-menu__item">Badge</a>
                               </li>
                               <li class="slide">
                                   <a href="dropdowns.html" class="side-menu__item">Dropdowns</a>
                               </li>
                               <li class="slide">
                                   <a href="images_figures.html" class="side-menu__item">Images & Figures</a>
                               </li>
                               <li class="slide">
                                   <a href="listgroup.html" class="side-menu__item">List Group</a>
                               </li>
                               <li class="slide">
                                   <a href="navs_tabs.html" class="side-menu__item">Navs & Tabs</a>
                               </li>
                               <li class="slide">
                                   <a href="object-fit.html" class="side-menu__item">Object Fit</a>
                               </li>
                               <li class="slide">
                                   <a href="pagination.html" class="side-menu__item">Pagination</a>
                               </li>
                               <li class="slide">
                                   <a href="popovers.html" class="side-menu__item">Popovers</a>
                               </li>
                               <li class="slide">
                                   <a href="progress.html" class="side-menu__item">Progress</a>
                               </li>
                               <li class="slide">
                                   <a href="spinners.html" class="side-menu__item">Spinners</a>
                               </li>
                               <li class="slide">
                                   <a href="typography.html" class="side-menu__item">Typography</a>
                               </li>
                               <li class="slide">
                                   <a href="tooltips.html" class="side-menu__item">Tooltips</a>
                               </li>
                               <li class="slide">
                                   <a href="toasts.html" class="side-menu__item">Toasts</a>
                               </li>
                               <li class="slide">
                                   <a href="tags.html" class="side-menu__item">Tags</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-briefcase side-menu__icon"></i>
                               <span class="side-menu__label">Advanced UI</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Advanced UI</a>
                               </li>
                               <li class="slide">
                                   <a href="carousel.html" class="side-menu__item">Carousel</a>
                               </li>
                               <li class="slide">
                                   <a href="full-calendar.html" class="side-menu__item">Full Calendar</a>
                               </li>
                               <li class="slide">
                                   <a href="draggable-cards.html" class="side-menu__item">Draggable Cards</a>
                               </li>
                               <li class="slide">
                                   <a href="chat.html" class="side-menu__item">Chat</a>
                               </li>
                               <li class="slide">
                                   <a href="contacts.html" class="side-menu__item">Contacts</a>
                               </li>
                               <li class="slide">
                                   <a href="cards.html" class="side-menu__item">Cards</a>
                               </li>
                               <li class="slide">
                                   <a href="timeline.html" class="side-menu__item">Timeline</a>
                               </li>
                               <li class="slide">
                                   <a href="search.html" class="side-menu__item">Search</a>
                               </li>
                               <li class="slide">
                                   <a href="userlist.html" class="side-menu__item">Userlist</a>
                               </li>
                               <li class="slide">
                                   <a href="notification.html" class="side-menu__item">Notification</a>
                               </li>
                               <li class="slide">
                                   <a href="treeview.html" class="side-menu__item">Tree-view</a>
                               </li>
                               <li class="slide">
                                   <a href="modals_closes.html" class="side-menu__item">Modals & Closes</a>
                               </li>
                               <li class="slide">
                                   <a href="navbar.html" class="side-menu__item">Navbar</a>
                               </li>
                               <li class="slide">
                                   <a href="offcanvas.html" class="side-menu__item">Offcanvas</a>
                               </li>
                               <li class="slide">
                                   <a href="placeholders.html" class="side-menu__item">Placeholders</a>
                               </li>
                               <li class="slide">
                                   <a href="ratings.html" class="side-menu__item">ratings</a>
                               </li>
                               <li class="slide">
                                   <a href="scrollspy.html" class="side-menu__item">Scrollspy</a>
                               </li>
                               <li class="slide">
                                   <a href="swiperjs.html" class="side-menu__item">Swiper JS</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide__category -->
                       <li class="slide__category"><span class="category-name">Other Pages</span></li>
                       <!-- End::slide__category -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-palette side-menu__icon"></i>
                               <span class="side-menu__label">Pages</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Pages</a>
                               </li>
                               <li class="slide">
                                   <a href="profile.html" class="side-menu__item">Profile</a>
                               </li>
                               <li class="slide">
                                   <a href="aboutus.html" class="side-menu__item">About Us</a>
                               </li>
                               <li class="slide">
                                   <a href="settings.html" class="side-menu__item">Settings</a>
                               </li>
                               <li class="slide">
                                   <a href="invoice.html" class="side-menu__item">Invoice</a>
                               </li>
                               <li class="slide">
                                   <a href="pricing.html" class="side-menu__item">Pricing</a>
                               </li>
                               <li class="slide">
                                   <a href="gallery.html" class="side-menu__item">Gallery</a>
                               </li>
                               <li class="slide">
                                   <a href="notifications-list.html" class="side-menu__item">Notifications List</a>
                               </li>
                               <li class="slide">
                                   <a href="faq.html" class="side-menu__item">Faqs</a>
                               </li>
                               <li class="slide">
                                   <a href="success-message.html" class="side-menu__item">Success Message</a>
                               </li>
                               <li class="slide">
                                   <a href="danger-message.html" class="side-menu__item">Danger Message</a>
                               </li>
                               <li class="slide">
                                   <a href="warning-message.html" class="side-menu__item">Warning Message</a>
                               </li>
                               <li class="slide">
                                   <a href="empty.html" class="side-menu__item">Empty Page</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-shield side-menu__icon"></i>
                               <span class="side-menu__label">Utilities</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Utilities</a>
                               </li>
                               <li class="slide">
                                   <a href="breakpoints.html" class="side-menu__item">Breakpoints</a>
                               </li>
                               <li class="slide">
                                   <a href="display.html" class="side-menu__item">Display</a>
                               </li>
                               <li class="slide">
                                   <a href="borders.html" class="side-menu__item">Borders</a>
                               </li>
                               <li class="slide">
                                   <a href="colors.html" class="side-menu__item">Colors</a>
                               </li>
                               <li class="slide">
                                   <a href="flex.html" class="side-menu__item">Flex</a>
                               </li>
                               <li class="slide">
                                   <a href="columns.html" class="side-menu__item">Columns</a>
                               </li>
                               <li class="slide">
                                   <a href="gutters.html" class="side-menu__item">Gutters</a>
                               </li>
                               <li class="slide">
                                   <a href="helpers.html" class="side-menu__item">Helpers</a>
                               </li>
                               <li class="slide">
                                   <a href="position.html" class="side-menu__item">Position</a>
                               </li>
                               <li class="slide">
                                   <a href="more.html" class="side-menu__item">More</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-menu side-menu__icon"></i>
                               <span class="side-menu__label">Submenu</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Submenu</a>
                               </li>
                               <li class="slide">
                                   <a href="javascript:void(0);" class="side-menu__item">Submenu-01</a>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Submenu-02
                                       <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="javascript:void(0);" class="side-menu__item">Level-01</a>
                                       </li>
                                       <li class="slide has-sub">
                                           <a href="javascript:void(0);" class="side-menu__item">Level-02
                                               <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                           <ul class="slide-menu child3">
                                               <li class="slide">
                                                   <a href="javascript:void(0);" class="side-menu__item">Level-11</a>
                                               </li>
                                               <li class="slide">
                                                   <a href="javascript:void(0);" class="side-menu__item">Level-12</a>
                                               </li>
                                           </ul>
                                       </li>
                                   </ul>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-lock side-menu__icon"></i>
                               <span class="side-menu__label">Authentication</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Authentication</a>
                               </li>
                               <li class="slide">
                                   <a href="signin.html" class="side-menu__item">Sign In</a>
                               </li>
                               <li class="slide">
                                   <a href="signup.html" class="side-menu__item">Sign Up</a>
                               </li>
                               <li class="slide">
                                   <a href="forgot.html" class="side-menu__item">Forgot Password</a>
                               </li>
                               <li class="slide">
                                   <a href="reset.html" class="side-menu__item">Reset Password</a>
                               </li>
                               <li class="slide">
                                   <a href="lockscreen.html" class="side-menu__item">Lockscreen</a>
                               </li>
                               <li class="slide">
                                   <a href="underconstruction.html" class="side-menu__item">UnderConstruction</a>
                               </li>
                               <li class="slide">
                                   <a href="404.html" class="side-menu__item">404 Error</a>
                               </li>
                               <li class="slide">
                                   <a href="500.html" class="side-menu__item">500 Error</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide__category -->
                       <li class="slide__category"><span class="category-name">Forms &amp; Charts</span></li>
                       <!-- End::slide__category -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-receipt side-menu__icon"></i>
                               <span class="side-menu__label">Forms</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>
                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Forms</a>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Form Elements
                                       <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                       <ul class="slide-menu child2">
                                           <li class="slide">
                                               <a href="form_inputs.html" class="side-menu__item">Inputs</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_check_radios.html" class="side-menu__item">Checks & Radios</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_input_group.html" class="side-menu__item">Input Group</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_select.html" class="side-menu__item">Form Select</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_range.html" class="side-menu__item">Range Slider</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_input_masks.html" class="side-menu__item">Input Masks</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_file_uploads.html" class="side-menu__item">File Uploads</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_dateTime_pickers.html" class="side-menu__item">Date,Time Picker</a>
                                           </li>
                                           <li class="slide">
                                               <a href="form_color_pickers.html" class="side-menu__item">Color Picker</a>
                                           </li>
                                       </ul>
                               </li>
                               <li class="slide">
                                   <a href="floating_labels.html" class="side-menu__item">Floating Labels</a>
                               </li>
                               <li class="slide">
                                   <a href="form_layout.html" class="side-menu__item">Form Layouts</a>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Form Editor<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="quill_editor.html" class="side-menu__item">Quill Editor</a>
                                       </li>
                                   </ul>
                               </li>
                               <li class="slide">
                                   <a href="form_validation.html" class="side-menu__item">Validation</a>
                               </li>
                               <li class="slide">
                                   <a href="form_select2.html" class="side-menu__item">Select2</a>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->

                       <!-- Start::slide -->
                       <li class="slide has-sub">
                           <a href="javascript:void(0);" class="side-menu__item">
                               <span class="shape1"></span>
                               <span class="shape2"></span>
                               <i class="ti-bar-chart-alt side-menu__icon"></i>
                               <span class="side-menu__label">Charts</span>
                               <i class="fe fe-chevron-right side-menu__angle"></i>

                           </a>
                           <ul class="slide-menu child1">
                               <li class="slide side-menu__label1">
                                   <a href="javascript:void(0)">Charts</a>
                               </li>
                               <li class="slide">
                                   <a href="chartjs-charts.html" class="side-menu__item">ChartJS</a>
                               </li>
                               <li class="slide">
                                   <a href="echarts.html" class="side-menu__item">Echart</a>
                               </li>
                               <li class="slide has-sub">
                                   <a href="javascript:void(0);" class="side-menu__item">Apex Charts<i class="fe fe-chevron-right side-menu__angle"></i></a>
                                   <ul class="slide-menu child2">
                                       <li class="slide">
                                           <a href="apex-line-charts.html" class="side-menu__item">Line Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-area-charts.html" class="side-menu__item">Area Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-column-charts.html" class="side-menu__item">Column Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-bar-charts.html" class="side-menu__item">Bar Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-mixed-charts.html" class="side-menu__item">Mixed Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-rangearea-charts.html" class="side-menu__item">Range Area Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-timeline-charts.html" class="side-menu__item">Timeline Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-candlestick-charts.html" class="side-menu__item">CandleStick Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-boxplot-charts.html" class="side-menu__item">Boxplot Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-bubble-charts.html" class="side-menu__item">Bubble Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-scatter-charts.html" class="side-menu__item">Scatter Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-heatmap-charts.html" class="side-menu__item">Heatmap Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-treemap-charts.html" class="side-menu__item">Treemap Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-pie-charts.html" class="side-menu__item">Pie Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-radialbar-charts.html" class="side-menu__item">Radialbar Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-radar-charts.html" class="side-menu__item">Radar Charts</a>
                                       </li>
                                       <li class="slide">
                                           <a href="apex-polararea-charts.html" class="side-menu__item">Polararea Charts</a>
                                       </li>
                                   </ul>
                               </li>
                           </ul>
                       </li>
                       <!-- End::slide -->
                   </ul>
                   <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
               </nav>
               <!-- End::nav -->

           </div>
           <!-- End::main-sidebar -->

       </aside>
       <!-- End::app-sidebar -->

       <!-- Start::app-content -->
       <div class="main-content app-content">
           <div class="container-fluid">

               <!-- Page Header -->

               <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                 <div>
                     <h2 class="main-content-title fs-24 mb-1">All Users</h2>
                     <ol class="breadcrumb mb-0">
                         <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
                         <li class="breadcrumb-item active" aria-current="page">User List</li>
                     </ol>
                 </div>
                 <div class="d-flex">

                 </div>
               </div>

               <!-- Start:: row-3 -->
               <div class="row">
                   <div class="col-xl-12">
                       <div class="card custom-card">
                           <div class="card-header">
                               <div class="card-title">
                                   User List
                               </div>
                           </div>
                           <div class="card-body">
                               <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap" style="width:100%">
                                   <thead>
                                       <tr>
                                           <th>Name</th>
                                           <th>Email</th>
                                           <th>Assigned Role</th>
                                           <th>Action</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <!-- Action buttons like Edit/Delete -->
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                               </table>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- End:: row-3 -->


           </div>
       </div>
       <!-- End::app-content -->




   </div>

    @include('partials.commonjs')

    <!-- JSVector Maps JS -->
    <script src="{{ asset('libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('libs/jsvectormap/maps/world-merc.js') }}"></script>
    <!-- Apex Charts JS -->
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Main-Dashboard -->
    <script src="{{ asset('js/index.js') }}"></script>

    @include('partials.custom_switcherjs')

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
