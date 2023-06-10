<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="#" style=" font-size: 25px; color:#1E85F1 ">
            <span style="color: #FFD700">G</span>olden <span style="color: #FFD700">G</span>ym </a>
        <img src="{{ URL::asset('assets/image/logo.png') }}" class="main-logo" alt="logo">

        <a class="desktop-logo logo-dark active" href="#"><img src="{{ URL::asset('assets/image/logo.png') }}"
                class="main-logo dark-theme" alt="logo"></a>

    </div>
    <div class="main-sidemenu">
        <ul class="side-menu">
            <li class="slide">
                <a class="side-menu__item" href="{{ route('home') }}">
                    <i class="fa fa-home" aria-hidden="true" style="font-size: 20px"></i>
                    &nbsp;&nbsp;&nbsp;
                    <span class="side-menu__label">الرئيسية</span></a>
            </li>
            @role('admin')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-magic" style="font-size: 20px" aria-hidden="true"></i>

                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة الصلاحيات والأدوار
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('roles.index') }}">المسميات الوظيفية والمهن</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('permissions.index') }}">الصلاحيات </a>
                        </li>
                    </ul>
                </li>
            @endrole


            {{-- قسم ة شفتات العمل والمواعيد --}}
            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        {{-- <i class="fa fa-user" aria-hidden="true" style="font-size: 20px"></i> --}}
                        <i class="fas fa-clock" style="font-size: 20px"></i>

                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            أوقات العمل والمواعيد
                        </span> <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('schedules.index') }}">المواعيد والأوقات</a>
                        </li>

                    </ul>
                </li>
            @endrole
            {{-- قسم الموظفين  --}}
            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-user" aria-hidden="true" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة الموظفين
                        </span> <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('users.index') }}">قائمة الموظفين</a>
                        </li>

                    </ul>
                </li>
            @endrole
            {{-- قسم المدربين --}}
            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-users" aria-hidden="true" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة المدربين
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">

                        <li>
                            <a class="slide-item" href="{{ route('trainers.index') }}">قائمة المدربين</a>
                        </li>
                        <li>

                        </li>
                    </ul>
                </li>
            @endrole
            @role(['admin', 'accountant'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-dumbbell" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;
                        <span class="side-menu__label">
                            إدارة الإشتراكات
                        </span> <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('subscriptions.index') }}">قائمة الإشتراكات</a>
                        </li>

                    </ul>
                </li>
            @endrole

            @role(['admin', 'accountant'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-users" aria-hidden="true" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة المشتركين
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('subscribers.index') }}">قائمة المشتركين</a>
                        </li>

                    </ul>
                </li>
            @endrole

            @role(['admin', 'vendor', 'accountant'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-list" style="font-size: 20px"></i> &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة الحضور والإنصراف
                            @php
                                
                                $numUnreadAttendancesUsers = App\Models\Attendance::where('order_status', null)->count();
                                $trainerAttendanceunread = App\Models\TrainerAttendance::where('order_status', null)->count();
                                
                            @endphp
                            @role(['admin'])
                                @if ($numUnreadAttendancesUsers != 0)
                                    &nbsp; <span class="badge bg-danger"
                                        style="color: white">{{ $numUnreadAttendancesUsers }}&nbsp;</span>
                                @endif
                                @if ($trainerAttendanceunread != 0)
                                    &nbsp;<span class="badge bg-warning text-dark"
                                        style="color: white">&nbsp;{{ $trainerAttendanceunread }}</span>
                                @endif
                            @endrole

                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @role(['accountant', 'vendor', 'secretary'])
                            <li>
                                <a class="slide-item" href="{{ route('attendance.index') }}">تسجيل حضور وإنصراف</a>
                            </li>
                            {{-- <li>
                                <a class="slide-item" href="{{ route('sheet-report', Auth::user()->id) }}">تقرير حضور
                                    وإنصراف</a>
                            </li> --}}
                        @endrole

                        @role('admin')
                            <li>
                                <a class="slide-item" href="{{ route('attendance.attendanceRequests') }}"> طلبات
                                    الحضور الموظفين
                                    @if ($numUnreadAttendancesUsers != 0)
                                        &nbsp; <span class="badge bg-danger"
                                            style="color: white">{{ $numUnreadAttendancesUsers }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="slide-item" href="{{ route('trainerAttendance.index') }}">
                                    طلبات حضور المدربين
                                    @if ($trainerAttendanceunread != 0)
                                        &nbsp;<span class="badge bg-warning text-dark"
                                            style="color: white">&nbsp;{{ $trainerAttendanceunread }}</span>
                                    @endif
                                </a>

                            </li>
                        @endrole

                    </ul>
                </li>
            @endrole
            @role(['admin', 'vendor', 'accountant'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fab fa-product-hunt" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة المنتجات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="{{ route('categories.index') }}">قائمة الفئات</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('categories.create') }}">اضافة فئة جديدة</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('products.index') }}">قائمة المنتجات</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('products.create') }}">اضافة منتج جديد </a>
                        </li>
                        <li>
                            <a class="slide-item" href="#">بيع منتج</a>
                        </li>
                    </ul>
                </li>
            @endrole
            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-star" aria-hidden="true" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة التقيمات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="#">قائمة التقيمات</a>
                        </li>


                    </ul>
                </li>
            @endrole



            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-bell"style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة الإشعارات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="#"> إضافة إشعارات</a>
                        </li>


                    </ul>
                </li>
            @endrole
            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-archive" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;

                        <span class="side-menu__label">
                            إدارة صندوق الشكاوي &nbsp;
                            @php
                                
                                $numUnreadComplaints = App\Models\Complaint::where('status', false)->count();
                                
                            @endphp
                            @if ($numUnreadComplaints != 0)
                                <span class="badge bg-danger" style="color: white">{{ $numUnreadComplaints }}</span>
                            @endif
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>

                            <a class="slide-item" href="{{ route('complaints.index') }}">عرض الشكاوي</a>
                        </li>
                        <li>

                            <a class="slide-item" href="{{ route('complaints.archives') }}">الإرشيف</a>
                        </li>


                    </ul>
                </li>
            @endrole

            @role(['admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="far fa-money-bill-alt" style="font-size: 20px"></i>
                        &nbsp;&nbsp;&nbsp;
                        <span class="side-menu__label">
                            إدارة الصادرات والواردات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        <li>
                            <a class="slide-item" href="#">قائمة الصادرات</a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{ route('incomings.index') }}">قائمة الواردات</a>
                        </li>
                    </ul>
                </li>
            @endrole

            <li class="slide">
                <hr>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-users-cog" style="font-size: 20px"></i>
                    &nbsp;&nbsp;&nbsp;
                    <span class="side-menu__label">
                        الإعدادات
                    </span><i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li>
                        <a class="slide-item" href="#"> setting </a>
                    </li>



                </ul>
            </li>



        </ul>
    </div>
</aside>
<!-- main-sidebar -->
