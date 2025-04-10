@extends('layouts.app')

@section('title', 'Dashboard | Central Invoice System')

@section('content')

    <style>
        .profile-cover__action {
            display: flex;
            padding-block-start: 216px;
            padding-inline-end: 30px;
            padding-block-end: 10px;
            padding-inline-start: 185px;
            border-radius: 5px;
            flex-wrap: wrap;
            justify-content: flex-end;
            overflow: hidden;
            background: url({{ asset($profile->cover_image) }}) no-repeat;
            background-size: cover;
        }
    </style>
    <div class="page">


        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->

                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">My Profile</h2>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Data</li>
                        </ol>
                    </div>
                </div>

                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row square row-sm">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="panel profile-cover">

                                    {{-- Profile Cover Photo --}}
                                    <div class="profile-cover__img" center center/cover no-repeat;">
                                        {{-- Profile Image --}}
                                        <img src="{{ $profile->profile_image ? asset($profile->profile_image) : asset('uploads/profile/default-profile.png') }}"
                                            alt="img" style="object-fit: cover;">

                                        {{-- Username or Name --}}
                                        <h3 class="h3">{{ $profile->username ?? $user->name }}</h3>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="btn-profile">
                                        <button class="btn rounded-10 btn-danger">
                                            <i class="fa fa-plus"></i>
                                            <span>Follow</span>
                                        </button>
                                        <button class="btn rounded-10 btn-success">
                                            <i class="fa fa-comment"></i>
                                            <span>Message</span>
                                        </button>
                                    </div>

                                    {{-- Overlay --}}
                                    <div class="profile-cover__action bg-img"></div>

                                    {{-- Stats (static for now) --}}
                                    <div class="profile-cover__info">
                                        <ul class="nav">
                                            <li><strong>26</strong>Projects</li>
                                            <li><strong>33</strong>Followers</li>
                                            <li><strong>136</strong>Following</li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Tabs --}}
                                <div class="profile-tab tab-menu-heading">
                                    <nav class="nav main-nav-line p-3 tabs-menu profile-nav-line">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#about">About</a>
                                        <a class="nav-link" data-bs-toggle="tab" href="#edit">Edit Profile</a>
                                        <a class="nav-link" data-bs-toggle="tab" href="#settings">Account Settings</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12 col-md-12">
                        <div class="card custom-card main-content-body-profile">
                            <div class="tab-content">
                                <div class="main-content-body tab-pane p-4 border-top-0 active" id="about">
                                    <div class="border rounded-10">
                                        <div class="p-4">
                                            <h4 class="fs-15 text-uppercase mb-3">BIOdata</h4>
                                            <p class="m-b-5">{{ $profile->bio ?? 'Need to Update' }}</p>

                                            <div class="m-t-30">
                                                <h4 class="fs-15 text-uppercase mt-3">Experience</h4>
                                                <div class="p-t-10">
                                                    <h5 class="text-primary m-b-5 fs-14">Lead designer / Developer</h5>
                                                    <p>{{ $profile->experience ?? 'Need to Update' }}</p>
                                                    <p><b>2010-2015</b></p>
                                                    <p class="text-muted fs-13 m-b-0">Lorem Ipsum is simply dummy text of
                                                        the printing and typesetting industry...</p>
                                                </div>

                                                <div class="">
                                                    <h5 class="text-primary m-b-5 fs-14">Senior Graphic Designer</h5>
                                                    <p>coderthemes.com</p>
                                                    <p><b>2007-2009</b></p>
                                                    <p class="text-muted fs-13 mb-0">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>

                                        <div class="p-4">
                                            <label class="main-content-label fs-13 mg-b-20">Contact</label>
                                            <div class="d-sm-flex">
                                                <div class="mb-3 mb-sm-0">
                                                    <div class="main-profile-contact-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-primary-transparent text-primary"> <i
                                                                    class="bi bi-telephone-forward"></i> </div>
                                                            <div class="media-body">
                                                                <span>Mobile</span>
                                                                <div>{{ $profile->mobile ?? 'Need to Update' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ms-0 ms-sm-3 mb-3 mb-sm-0">
                                                    <div class="main-profile-contact-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-success-transparent text-success"> <i
                                                                    class="bi bi-lightning-charge"></i> </div>
                                                            <div class="media-body">
                                                                <span>Slack</span>
                                                                <div>{{ $profile->slack ?? 'Need to Update' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ms-0 ms-sm-3 mb-3 mb-sm-0">
                                                    <div class="main-profile-contact-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-info-transparent text-info"> <i
                                                                    class="bi bi-geo-alt"></i> </div>
                                                            <div class="media-body">
                                                                <span>Current Address</span>
                                                                <div>{{ $profile->location ?? 'Need to Update' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top"></div>

                                        <div class="p-3 p-sm-4">
                                            <label class="main-content-label fs-13 mg-b-20">Social</label>
                                            <div class="d-xl-flex">
                                                <div class="mb-3 mb-xl-0">
                                                    <div class="main-profile-social-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-primary-transparent text-primary"> <i
                                                                    class="bi bi-github"></i> </div>
                                                            <div class="media-body">
                                                                <span>Github</span>
                                                                <a href="{{ $profile->github ?? 'javascript:void(0);' }}">
                                                                    {{ $profile->github ?? 'Need to Update' }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ms-0 ms-xl-3 mb-3 mb-xl-0">
                                                    <div class="main-profile-social-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-success-transparent text-success"> <i
                                                                    class="bi bi-twitter"></i> </div>
                                                            <div class="media-body">
                                                                <span>Twitter</span>
                                                                <a
                                                                    href="{{ $profile->twitter ?? 'javascript:void(0);' }}">
                                                                    {{ $profile->twitter ?? 'Need to Update' }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ms-0 ms-xl-3 mb-3 mb-xl-0">
                                                    <div class="main-profile-social-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-info-transparent text-info"> <i
                                                                    class="bi bi-linkedin"></i> </div>
                                                            <div class="media-body">
                                                                <span>Linkedin</span>
                                                                <a
                                                                    href="{{ $profile->linkedin ?? 'javascript:void(0);' }}">
                                                                    {{ $profile->linkedin ?? 'Need to Update' }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ms-0 ms-xl-3 mb-3 mb-xl-0">
                                                    <div class="main-profile-social-list">
                                                        <div class="media">
                                                            <div class="media-icon bg-danger-transparent text-danger"> <i
                                                                    class="bi bi-link-45deg"></i> </div>
                                                            <div class="media-body">
                                                                <span>My Portfolio</span>
                                                                <a
                                                                    href="{{ $profile->portfolio ?? 'javascript:void(0);' }}">
                                                                    {{ $profile->portfolio ?? 'Need to Update' }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="main-content-body tab-pane p-4 border-top-0" id="edit">
                                    <div class="card-body border">
                                        <div class="mb-4 main-content-label">Profile Information</div>

                                        <form class="form-horizontal" action="{{ route('profile.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')

                                            {{-- Profile Photo --}}
                                            <div class="form-group">
                                                <label class="form-label">Profile Photo</label>
                                                <input type="file" name="profile_image" class="form-control">

                                                {{-- Profile Image Preview --}}
                                                <div class="mt-2">
                                                    <img src="{{ $profile->profile_image }}" alt="Profile Image"
                                                        class="rounded" width="100" height="100">
                                                </div>
                                            </div>

                                            {{-- Cover Photo --}}
                                            <div class="form-group">
                                                <label class="form-label">Cover Photo</label>
                                                <input type="file" name="cover_image" class="form-control">

                                                {{-- Cover Image Preview --}}
                                                <div class="mt-2">
                                                    <img src="{{ $profile->cover_image }}" alt="Cover Image"
                                                        class="rounded" width="150" height="80">
                                                </div>
                                            </div>


                                            {{-- Bio --}}
                                            <div class="form-group">
                                                <label class="form-label">Bio</label>
                                                <textarea name="bio" class="form-control" rows="3" placeholder="Write something...">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                            </div>

                                            {{-- Experience --}}
                                            <div class="form-group">
                                                <label class="form-label">Experience</label>
                                                <input type="text" name="experience" class="form-control"
                                                    value="{{ old('experience', $profile->experience ?? '') }}">
                                            </div>

                                            {{-- Location --}}
                                            <div class="form-group">
                                                <label class="form-label">Location</label>
                                                <input type="text" name="location" class="form-control"
                                                    value="{{ old('location', $profile->location ?? '') }}">
                                            </div>

                                            {{-- Mobile --}}
                                            <div class="form-group">
                                                <label class="form-label">Mobile</label>
                                                <input type="text" name="mobile" class="form-control"
                                                    value="{{ old('mobile', $profile->mobile ?? '') }}">
                                            </div>

                                            {{-- Slack --}}
                                            <div class="form-group">
                                                <label class="form-label">Slack</label>
                                                <input type="text" name="slack" class="form-control"
                                                    value="{{ old('slack', $profile->slack ?? '') }}">
                                            </div>

                                            {{-- Portfolio --}}
                                            <div class="form-group">
                                                <label class="form-label">Portfolio</label>
                                                <input type="text" name="portfolio" class="form-control"
                                                    value="{{ old('portfolio', $profile->portfolio ?? '') }}">
                                            </div>

                                            <div class="mb-4 main-content-label">Social Info</div>

                                            {{-- GitHub --}}
                                            <div class="form-group">
                                                <label class="form-label">GitHub</label>
                                                <input type="text" name="github" class="form-control"
                                                    value="{{ old('github', $profile->github ?? '') }}">
                                            </div>

                                            {{-- Twitter --}}
                                            <div class="form-group">
                                                <label class="form-label">Twitter</label>
                                                <input type="text" name="twitter" class="form-control"
                                                    value="{{ old('twitter', $profile->twitter ?? '') }}">
                                            </div>

                                            {{-- LinkedIn --}}
                                            <div class="form-group">
                                                <label class="form-label">LinkedIn</label>
                                                <input type="text" name="linkedin" class="form-control"
                                                    value="{{ old('linkedin', $profile->linkedin ?? '') }}">
                                            </div>

                                            {{-- Submit --}}
                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="main-content-body tab-pane p-4 border-top-0" id="settings">
                                    <div class="card-body border" data-select2-id="12">
                                        <form class="form-horizontal" data-select2-id="11">
                                            <div class="mb-4 main-content-label">Account</div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">User Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="User Name" value="Sonia Taylor">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" placeholder="Email"
                                                            value="info@SoniaTaylor.in">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group " data-select2-id="108">
                                                <div class="row" data-select2-id="107">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Language</label>
                                                    </div>
                                                    <div class="col-md-9" data-select2-id="106">
                                                        <select class="form-control select2" data-select2-id="5"
                                                            tabindex="-1" aria-hidden="true" data-trigger>
                                                            <option data-select2-id="33">Us English</option>
                                                            <option data-select2-id="109">Arabic</option>
                                                            <option data-select2-id="110">Korean</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group " data-select2-id="10">
                                                <div class="row" data-select2-id="9">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Timezone</label>
                                                    </div>
                                                    <div class="col-md-9" data-select2-id="8">
                                                        <select class="form-control select2" data-select2-id="4"
                                                            tabindex="-1" aria-hidden="true" data-trigger>
                                                            <option value="Pacific/Midway" data-select2-id="6">(GMT-11:00)
                                                                Midway Island, Samoa</option>
                                                            <option value="America/Adak" data-select2-id="16">(GMT-10:00)
                                                                Hawaii-Aleutian</option>
                                                            <option value="Etc/GMT+10" data-select2-id="17">(GMT-10:00)
                                                                Hawaii</option>
                                                            <option value="Pacific/Marquesas" data-select2-id="18">
                                                                (GMT-09:30) Marquesas Islands</option>
                                                            <option value="Pacific/Gambier" data-select2-id="19">
                                                                (GMT-09:00) Gambier Islands</option>
                                                            <option value="America/Anchorage" data-select2-id="20">
                                                                (GMT-09:00) Alaska</option>
                                                            <option value="America/Ensenada" data-select2-id="21">
                                                                (GMT-08:00) Tijuana, Baja California</option>
                                                            <option value="Etc/GMT+8" data-select2-id="22">(GMT-08:00)
                                                                Pitcairn Islands</option>
                                                            <option value="America/Los_Angeles" data-select2-id="23">
                                                                (GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                                            <option value="America/Denver" data-select2-id="24">
                                                                (GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                                            <option value="America/Chihuahua" data-select2-id="25">
                                                                (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                            <option value="America/Dawson_Creek" data-select2-id="26">
                                                                (GMT-07:00) Arizona</option>
                                                            <option value="America/Belize" data-select2-id="27">
                                                                (GMT-06:00) Saskatchewan, Central America</option>
                                                            <option value="America/Cancun" data-select2-id="28">
                                                                (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                            <option value="Chile/EasterIsland" data-select2-id="29">
                                                                (GMT-06:00) Easter Island</option>
                                                            <option value="America/Chicago" data-select2-id="30">
                                                                (GMT-06:00) Central Time (US &amp; Canada)</option>
                                                            <option value="America/New_York" data-select2-id="31">
                                                                (GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                                            <option value="America/Havana" data-select2-id="32">
                                                                (GMT-05:00) Cuba</option>
                                                            <option value="America/Bogota" data-select2-id="33">
                                                                (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                            <option value="America/Caracas" data-select2-id="34">
                                                                (GMT-04:30) Caracas</option>
                                                            <option value="America/Santiago" data-select2-id="35">
                                                                (GMT-04:00) Santiago</option>
                                                            <option value="America/La_Paz" data-select2-id="36">
                                                                (GMT-04:00) La Paz</option>
                                                            <option value="Atlantic/Stanley" data-select2-id="37">
                                                                (GMT-04:00) Faukland Islands</option>
                                                            <option value="America/Campo_Grande" data-select2-id="38">
                                                                (GMT-04:00) Brazil</option>
                                                            <option value="America/Goose_Bay" data-select2-id="39">
                                                                (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                            <option value="America/Glace_Bay" data-select2-id="40">
                                                                (GMT-04:00) Atlantic Time (Canada)</option>
                                                            <option value="America/St_Johns" data-select2-id="41">
                                                                (GMT-03:30) Newfoundland</option>
                                                            <option value="America/Araguaina" data-select2-id="42">
                                                                (GMT-03:00) UTC-3</option>
                                                            <option value="America/Montevideo" data-select2-id="43">
                                                                (GMT-03:00) Montevideo</option>
                                                            <option value="America/Miquelon" data-select2-id="44">
                                                                (GMT-03:00) Miquelon, St. Pierre</option>
                                                            <option value="America/Godthab" data-select2-id="45">
                                                                (GMT-03:00) Greenland</option>
                                                            <option value="America/Argentina/Buenos_Aires"
                                                                data-select2-id="46">(GMT-03:00) Buenos Aires</option>
                                                            <option value="America/Sao_Paulo" data-select2-id="47">
                                                                (GMT-03:00) Brasilia</option>
                                                            <option value="America/Noronha" data-select2-id="48">
                                                                (GMT-02:00) Mid-Atlantic</option>
                                                            <option value="Atlantic/Cape_Verde" data-select2-id="49">
                                                                (GMT-01:00) Cape Verde Is.</option>
                                                            <option value="Atlantic/Azores" data-select2-id="50">
                                                                (GMT-01:00) Azores</option>
                                                            <option value="Europe/Belfast" data-select2-id="51">(GMT)
                                                                Greenwich Mean Time : Belfast</option>
                                                            <option value="Europe/Dublin" data-select2-id="52">(GMT)
                                                                Greenwich Mean Time : Dublin</option>
                                                            <option value="Europe/Lisbon" data-select2-id="53">(GMT)
                                                                Greenwich Mean Time : Lisbon</option>
                                                            <option value="Europe/London" data-select2-id="54">(GMT)
                                                                Greenwich Mean Time : London</option>
                                                            <option value="Africa/Abidjan" data-select2-id="55">(GMT)
                                                                Monrovia, Reykjavik</option>
                                                            <option value="Europe/Amsterdam" data-select2-id="56">
                                                                (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                                                            </option>
                                                            <option value="Europe/Belgrade" data-select2-id="57">
                                                                (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana,
                                                                Prague</option>
                                                            <option value="Europe/Brussels" data-select2-id="58">
                                                                (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                            <option value="Africa/Algiers" data-select2-id="59">
                                                                (GMT+01:00) West Central Africa</option>
                                                            <option value="Africa/Windhoek" data-select2-id="60">
                                                                (GMT+01:00) Windhoek</option>
                                                            <option value="Asia/Beirut" data-select2-id="61">(GMT+02:00)
                                                                Beirut</option>
                                                            <option value="Africa/Cairo" data-select2-id="62">(GMT+02:00)
                                                                Cairo</option>
                                                            <option value="Asia/Gaza" data-select2-id="63">(GMT+02:00)
                                                                Gaza</option>
                                                            <option value="Africa/Blantyre" data-select2-id="64">
                                                                (GMT+02:00) Harare, Pretoria</option>
                                                            <option value="Asia/Jerusalem" data-select2-id="65">
                                                                (GMT+02:00) Jerusalem</option>
                                                            <option value="Europe/Minsk" data-select2-id="66">(GMT+02:00)
                                                                Minsk</option>
                                                            <option value="Asia/Damascus" data-select2-id="67">(GMT+02:00)
                                                                Syria</option>
                                                            <option value="Europe/Moscow" data-select2-id="68">(GMT+03:00)
                                                                Moscow, St. Petersburg, Volgograd</option>
                                                            <option value="Africa/Addis_Ababa" data-select2-id="69">
                                                                (GMT+03:00) Nairobi</option>
                                                            <option value="Asia/Tehran" data-select2-id="70">(GMT+03:30)
                                                                Tehran</option>
                                                            <option value="Asia/Dubai" data-select2-id="71">(GMT+04:00)
                                                                Abu Dhabi, Muscat</option>
                                                            <option value="Asia/Yerevan" data-select2-id="72">(GMT+04:00)
                                                                Yerevan</option>
                                                            <option value="Asia/Kabul" data-select2-id="73">(GMT+04:30)
                                                                Kabul</option>
                                                            <option value="Asia/Yekaterinburg" data-select2-id="74">
                                                                (GMT+05:00) Ekaterinburg</option>
                                                            <option value="Asia/Tashkent" data-select2-id="75">(GMT+05:00)
                                                                Tashkent</option>
                                                            <option value="Asia/Kolkata" data-select2-id="76">(GMT+05:30)
                                                                Chennai, Kolkata, Mumbai, New Delhi</option>
                                                            <option value="Asia/Katmandu" data-select2-id="77">(GMT+05:45)
                                                                Kathmandu</option>
                                                            <option value="Asia/Dhaka" data-select2-id="78">(GMT+06:00)
                                                                Astana, Dhaka</option>
                                                            <option value="Asia/Novosibirsk" data-select2-id="79">
                                                                (GMT+06:00) Novosibirsk</option>
                                                            <option value="Asia/Rangoon" data-select2-id="80">(GMT+06:30)
                                                                Yangon (Rangoon)</option>
                                                            <option value="Asia/Bangkok" data-select2-id="81">(GMT+07:00)
                                                                Bangkok, Hanoi, Jakarta</option>
                                                            <option value="Asia/Krasnoyarsk" data-select2-id="82">
                                                                (GMT+07:00) Krasnoyarsk</option>
                                                            <option value="Asia/Hong_Kong" data-select2-id="83">
                                                                (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                            <option value="Asia/Irkutsk" data-select2-id="84">(GMT+08:00)
                                                                Irkutsk, Ulaan Bataar</option>
                                                            <option value="Australia/Perth" data-select2-id="85">
                                                                (GMT+08:00) Perth</option>
                                                            <option value="Australia/Eucla" data-select2-id="86">
                                                                (GMT+08:45) Eucla</option>
                                                            <option value="Asia/Tokyo" data-select2-id="87">(GMT+09:00)
                                                                Osaka, Sapporo, Tokyo</option>
                                                            <option value="Asia/Seoul" data-select2-id="88">(GMT+09:00)
                                                                Seoul</option>
                                                            <option value="Asia/Yakutsk" data-select2-id="89">(GMT+09:00)
                                                                Yakutsk</option>
                                                            <option value="Australia/Adelaide" data-select2-id="90">
                                                                (GMT+09:30) Adelaide</option>
                                                            <option value="Australia/Darwin" data-select2-id="91">
                                                                (GMT+09:30) Darwin</option>
                                                            <option value="Australia/Brisbane" data-select2-id="92">
                                                                (GMT+10:00) Brisbane</option>
                                                            <option value="Australia/Hobart" data-select2-id="93">
                                                                (GMT+10:00) Hobart</option>
                                                            <option value="Asia/Vladivostok" data-select2-id="94">
                                                                (GMT+10:00) Vladivostok</option>
                                                            <option value="Australia/Lord_Howe" data-select2-id="95">
                                                                (GMT+10:30) Lord Howe Island</option>
                                                            <option value="Etc/GMT-11" data-select2-id="96">(GMT+11:00)
                                                                Solomon Is., New Caledonia</option>
                                                            <option value="Asia/Magadan" data-select2-id="97">(GMT+11:00)
                                                                Magadan</option>
                                                            <option value="Pacific/Norfolk" data-select2-id="98">
                                                                (GMT+11:30) Norfolk Island</option>
                                                            <option value="Asia/Anadyr" data-select2-id="99">(GMT+12:00)
                                                                Anadyr, Kamchatka</option>
                                                            <option value="Pacific/Auckland" data-select2-id="100">
                                                                (GMT+12:00) Auckland, Wellington</option>
                                                            <option value="Etc/GMT-12" data-select2-id="101">(GMT+12:00)
                                                                Fiji, Kamchatka, Marshall Is.</option>
                                                            <option value="Pacific/Chatham" data-select2-id="102">
                                                                (GMT+12:45) Chatham Islands</option>
                                                            <option value="Pacific/Tongatapu" data-select2-id="103">
                                                                (GMT+13:00) Nuku'alofa</option>
                                                            <option value="Pacific/Kiritimati" data-select2-id="104">
                                                                (GMT+14:00) Kiritimati</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3 col">
                                                        <label class="form-label">Verification</label>
                                                    </div>
                                                    <div class="col-md-9 col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckDefaul1">
                                                            <label class="form-check-label" for="flexCheckDefaul1">
                                                                Email
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckDefaul2" checked>
                                                            <label class="form-check-label" for="flexCheckDefaul2">
                                                                SMS
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckDefaul3">
                                                            <label class="form-check-label" for="flexCheckDefaul3">
                                                                Phone
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4 main-content-label">Secuirity Settings</div>
                                            <div class="form-group mb-0">
                                                <div class="row row-sm">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Login Verification</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <a class="" href="javascript:void(0);">Set up
                                                            Verification</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="row row-sm">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Password Verification</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckDefaul4">
                                                            <label class="form-check-label" for="flexCheckDefaul4">
                                                                Require Personal Details
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="row row-sm">
                                                    <div class="col-md-2"> </div>
                                                    <div class="col-md-10 d-inline-flex">
                                                        <a class="me-4" href="javascript:void(0);">Deactivate
                                                            Account</a> <a class=""
                                                            href="javascript:void(0);">Change Password</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
                <!--End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="input-group">
                            <input type="search" class="form-control px-2 " placeholder="Search..."
                                aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text bg-primary text-white"
                                id="Search-Grid"><i class="fe fe-search header-link-icon fs-18"></i></a>
                        </span>
                        <div class="mt-3">
                            <div class="">
                                <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                                <div class="ps-2">
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>People<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>Pages<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i
                                            class="fe fe-search me-2"></i>Articles<span></span></a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                                <ul class="ps-2">
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="full-calendar.html"><span><i
                                                    class='bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Calendar</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="mail.html"><span><i
                                                    class='bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle'></i>Mail</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="buttons.html"><span><i
                                                    class='bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Buttons</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                                <ul class="ps-2">
                                    <li class="p-1 align-items-center  mb-1 search-app">
                                        <a href="javascript:void(0)"
                                            class="text-primary"><u>http://spruko/html/spruko.com</u></a>
                                    </li>
                                    <li class="p-1 align-items-center mb-1 search-app">
                                        <a href="javascript:void(0)"
                                            class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block">
                        <div class="text-center">
                            <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all
                                results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
@section('scripts')
@endsection
