@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between hidden-print">
        <div class="my-auto hidden-print">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> <a href="{{ route('home') }}">الصفحة الرئيسية
                    </a>/</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    إدارة المدربين </span>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    سجل الحضور وأنصراف</span>

            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('statusS'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #14628c; color: white ; border-radius:15px; text-align: center">
            {{ session('statusS') }}
        </div>
    @endif
    @if (Session()->has('statusSL'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #14628c; color: white ; border-radius:15px; text-align: center">
            {{ session('statusSL') }}
        </div>
    @endif
    @if (Session()->has('statusF'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #da3813cf; color: white ; border-radius:15px; text-align: center">
            {{ session('statusF') }}
        </div>
    @endif
    @if (Session()->has('statusAtt'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #da3813cf; color: white ; border-radius:15px; text-align: center">
            {{ session('statusAtt') }}

        </div>
    @endif
    @if (Session()->has('statusleave'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #da3813cf; color: white ; border-radius:15px; text-align: center">
            {{ session('statusleave') }}

        </div>
    @endif
    @if (Session()->has('statusFL'))
        <div class="alert fw-bold" role="alert"
            style="background-color: #da3813cf; color: white ; border-radius:15px; text-align: center">
            {{ session('statusFL') }}

        </div>
    @endif



    <div class="card  hidden-print">
        <div class="card-header bg-info text-white" style="text-align: center">
            تسجيل الحضور والإنصراف الخاص بك لشهر <b style="color: #000; ">&nbsp;&nbsp; {{ date('M') }}</b>
            &nbsp;&nbsp; اليوم
            {{ date('d-m-Y') }} م
        </div>

        <div class="card-body">
            <div class="row" style="display: flex ; justify-content:space-around">
                <div class="col-2">
                    <form action="{{ route('attendance.attendances_store') }}" method="POST">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->name }}">
                        @csrf
                        <button class="btn btn-success">تسحيل حضور</button>
                    </form>
                </div>

                <div class="col-2">
                    <form action="{{ route('attendance.departure') }}" method="POST">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->name }}">
                        @csrf
                        <button class="btn btn-danger">تسحيل إنصراف</button>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="card card-info">
        <div class="card-header bg-light " style="text-align: center">
            سجيل الحضور والإنصراف الخاص بك لشهر <b style="color: #000">&nbsp;&nbsp; {{ date('M') }}</b>

        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table  class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                    <thead>
                        <tr>
                            <th>تاريخ اليوم</th>
                            <th>ساعة الحضور</th>
                            <th>ساعة الإنصراف</th>
                            <th>فترة العمل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($attendances))
                            @foreach ($attendances as $att)
                                <tr>
                                    <td>{{ $att->date }}</td>
                                    <td>
                                        @php
                                            $attendance_time = \Carbon\Carbon::parse($att->attendance_time)->format('h:i');
                                            
                                        @endphp
                                        {{ $attendance_time }}</td>
                                    <td>
                                        @php
                                            $leave_time = \Carbon\Carbon::parse($att->leave_time)->format('h:i');
                                            
                                        @endphp
                                        {{ $leave_time }}</td>
                                    <td>
                                        @php
                                            $duration_time = \Carbon\Carbon::parse($att->duration_time)->format('h:i');
                                            
                                        @endphp
                                        {{ $duration_time }}</td>
                                    <td>

                                        @if ($att->order_status == null)
                                            <span class="badge rounded-pill bg-danger">
                                                في إنتظار الاعتماد
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-success">
                                                تم الاعتماد

                                            </span>
                                        @endif


                                    </td>
                                </tr>
                                <tr style="text-align: left">
                                    @php
                                        $totalWorkingtime = \Carbon\Carbon::parse($totalWorkingTime)->format('h:i');
                                        
                                    @endphp
                                    <td colspan="4" style="padding-left:50px "> <span>المجموع :
                                            {{ $totalWorkingtime ?? null }} ₪. </span>
                                    </td>
                                </tr>
                            @endforeach

                        @endif





                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="d-flex my-xl-auto right-content hidden-print">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" onclick="printTable()" class="btn btn-info"><i class="fas fa-print"></i>
                &nbsp;طباعة</button>
        </div>
        <div class="pr-1 mb-3 mb-xl-0">
            <a href="" class="btn btn-success   ml-2"> <i class="fas fa-file-excel"></i>&nbsp;
                تصدير</i></a>
        </div>

    </div>
@endsection

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function printTable() {
            window.print();
        }

       
    </script>

     

@endsection
