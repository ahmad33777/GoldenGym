@extends('layouts.master')
@section('css')
  
@endsection
@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="row hidden-print">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trainers.index') }}">قائمة المدربين</a></li>
                    <li class="breadcrumb-item active"> تقرير حضور وإنصراف</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')




    <div class="row row-sm hidden-print" style="text-align: center">
        <div class="col-xl-12">
            <div class="card card-primary ">
                <div class="row p-3" >

                    @error('startDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror

                    @error('endDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.attendanceReport', $trainer->id) }}" method="GET" style="display: flex ; justify-content: space-around;">
                        <label for="startDate" style="margin-top:auto ">من تاريخ</label>
                        <div class="bootstrap-datepicker" style="width: 350px">
                            <input type="date" class="form-control timepicker" id="startDate" name="startDate"
                                value="{{ old('startDate') }}">
                        </div>


                        <button type="submit" class="btn btn-primary" name="search">
                            <i class="fas fa-search d-none d-md-block">&nbsp;&nbsp; بحث</i>
                        </button>
                        <label for="endDate" style="margin-top:auto ">إلى تاريخ</label>
                        <div class="bootstrap-datepicker" style="width: 350px">
                            <input type="date" class="form-control timepicker" id="endDate" name="endDate"
                                value="{{ old('endDate') }}">
                        </div>


                    </form>

                </div>
            </div>
        </div>
        <!--/div-->


    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">


                <div class="card-body">
                    <div class="card-header bg-info " style="text-align: center">
                        سجيل الحضور والإنصراف الخاص بالمدرب : <span style="font-weight: 900 ">{{ $trainer->name }}</span>

                    </div>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <th> تاريخ الحضور</th>
                                    <th>ساعة الحضور</th>
                                    <th>ساعة الإنصراف</th>
                                    <th>مدة العمل</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainerAttendances as $att)
                                    <tr>
                                        <td>{{ $att->date }}</td>
                                        @php
                                            $attendance_time = \Carbon\Carbon::parse($att->attendance_time)->format('h:i ');
                                        @endphp
                                        <td>
                                            {{ $attendance_time }}
                                            @if ($att->status_late == 1)
                                                <span class="badge bg-danger">متأخر</span>
                                            @endif
                                        </td>
                                        @php
                                            $leave_time = \Carbon\Carbon::parse($att->leave_time)->format('h:i ');
                                        @endphp
                                        <td>{{ $leave_time }}</td>
                                        <td>{{ $att->duration_time }}</td>
                                    </tr>
                                @endforeach
                                <tr style="text-align: left">
                                    <td colspan="4" style="padding-left:50px "> <span>المجموع :
                                            {{ $totalWorkingTime ?? null }} ساعة </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>




    <div class="d-flex my-xl-auto right-content hidden-print">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" onclick="printTable()" class="btn btn-info"><i class="fas fa-print"></i>
                &nbsp;طباعة</button>
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
