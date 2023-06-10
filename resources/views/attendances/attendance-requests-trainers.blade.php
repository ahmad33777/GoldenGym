@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item active">إدارة الحضور والإنصراف </li>
                    <li class="breadcrumb-item active">قبول الطلبات</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    {{-- main content --}}
    {{-- الرسالة عند الاضافة  --}}
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                تم قبول طلب الموظف
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #dd1212; color: white ; border-radius:15px;">
                لم يتم قبول الطلب
            </div>
        @endif
    @endif

    @if (Session()->has('rejectstatus'))
        @if (session('rejectstatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                تم رفض طلب الحضور
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #dd1212; color: white ; border-radius:15px;">
                فشلت عماية الرفض
            </div>
        @endif
    @endif
    <br>
    <!-- row -->

    <div class="row row-sm">
        <div class="col-xl-12">
            <br>
            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table  mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <th>الإسم</th>
                                    <th>تاريخ تسجيل الحضور</th>
                                    <th>وقت تسجيل الحضور</th>
                                    <td>بداية الدوام</td>
                                </tr>
                            </thead>
                            <tbody>

                                @if (isset($attendances))
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->trainer->name }}</td>
                                            <td>{{ $attendance->date }} </td>
                                            <td>
                                                @php
                                                    $attendance_time = \Carbon\Carbon::parse($attendance->attendance_time)->format('h:i ');
                                                @endphp
                                                {{ $attendance_time }}
                                                @if ($attendance->status_late == 1)
                                                    <span class="badge bg-danger">متأخر</span>
                                                @endif

                                            </td>
                                            <td>

                                                @php
                                                    
                                                    $time_in = \Carbon\Carbon::parse($attendance->trainer->schedules->first()->time_in)->format('h:i A');
                                                @endphp
                                                {{ $time_in }}
                                            </td>
                                            <td style="width: 100px">
                                                <form action="{{ route('trainerAttendance.acceptTrainerAttendance') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $attendance->date }}"
                                                        name="attendance_date">
                                                    <input type="hidden" value="{{ $attendance->trainer->id }}"
                                                        name="trainer_id">
                                                    <button type="submit" class="btn btn-success"
                                                        style="font-size: 12px; ">
                                                        اعتماد
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="width: 100px">
                                                <form action="{{ route('trainerAttendance.rejectionTrainerAttendance') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" value="{{ $attendance->date }}"
                                                        name="attendance_date">
                                                    <input type="hidden" value="{{ $attendance->trainer->id }}"
                                                        name="trainer_id">
                                                    <button type="submit" class="btn btn-danger" style="font-size: 12px; ">
                                                        رفض
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!--/div-->
    </div>




    </div>
    </div>
@endsection

@section('js')


@endsection
