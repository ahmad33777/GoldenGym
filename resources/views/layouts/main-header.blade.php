<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item hidden-print">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="#"><img src="{{ asset('assets/image/logo.png') }}" class="logo-1" alt="logo"></a>

                <a href="#"><img src="{{ asset('assets/image/logo.png') }}" class="logo-2" alt="logo"></a>
                <a href="#"><img src="{{ asset('assets/image/logo.png') }}" class="dark-logo-2"
                        alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                @php
                    $numUnreadComplaints = App\Models\Complaint::where('status', false)->count();
                    $complaints = App\Models\Complaint::with('subscriber')
                        ->where('status', false)
                        ->get();
                @endphp
                <div class="dropdown nav-item main-header-message ">
                    @role(['admin'])
                        @if ($numUnreadComplaints != 0)
                            <span class="badge bg-danger"
                                style="position :  absolute ; z-index:2; padding-top:20px  ;">{{ $numUnreadComplaints }}</span>
                        @endif
                    @endrole

                    <a class="new nav-link" href="#"><i class="fas fa-bell"></i></a>

                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-right">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الرسائل</h6>
                            </div>


                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">لديك
                                {{ $numUnreadComplaints }} رسائل غير
                                مقروءة</p>
                        </div>
                        <div class="main-message-list chat-scroll">
                            @if (isset($complaints))
                                @foreach ($complaints as $complaint)
                                    <a href="#" class="p-3  d-flex border-bottom">
                                        <div class="wd-90p">
                                            <div class="d-flex">
                                                <h5 class="mb-1 name">{{ $complaint->subscriber->name }} </h5>
                                            </div>
                                            <p class="mb-0 desc">{{ $complaint->complaint }}</p>
                                            <p class="time mb-0 text-left float-right mr-2 mt-2">
                                                {{ $complaint->created_at }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            @endif



                        </div>
                        <div class="text-center dropdown-footer">
                            <a href="{{ route('complaints.index') }}" href="text-center">عرض الكل</a>
                        </div>
                    </div>
                </div>

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>

                <div class="nav-item full-screen fullscreen-button">
                    <p style="margin-top:15px ">{{ Auth()->user()->roles->first()->name ?? null }}</p>
                    {{-- <p style="margin-top:15px">المسمى الوظيفي</p> --}}
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt=""
                            src="{{ URL::asset('assets/img/faces/6.jpg') }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt=""
                                        src="{{ URL::asset('assets/img/faces/6.jpg') }}" class=""></div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ Auth::User()->name }}</h6><span>{{ Auth::User()->email }}</span>
                                </div>
                            </div>
                        </div>

                        <a class="dropdown-item" href="{{ route('profiles.edit', Auth::User()->id) }}"><i
                                class="bx bx-cog"></i>
                            تعديل
                            الملف الشخصي </a>
                        <a class="dropdown-item" href="{{ route('changePassword') }}"><i
                                class="bx bxs-inbox"></i>تغير كلمة المرورو </a>
                        <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>البريد اللإلكتروني</a>
                        <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i>اللإعدادات</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                class="bx bx-log-out"></i>تسجيل خروج</a>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- /main-header -->
