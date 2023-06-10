@extends('layouts.master')

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
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">قائمة الموظفين</a></li>
                    <li class="breadcrumb-item active"> تقرير حضور وإنصراف </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')




    <br>
    <div class="row row-sm hidden-print">
        <div class="col-xl-12">
            <div class="card card-primary ">
                <div class="row p-3" style="display: flex ; justify-content: space-around;">
                    @error('startDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror

                    @error('endDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror
                </div>
                <div class="card-body">
                    <form action="{{ route('searchattendanceReport', $user->id) }}" method="GET"
                        style="display: flex ; justify-content: space-around;">
                        <label for="startDate" style="margin-top:auto ">من تاريخ</label>
                        <div class="bootstrap-datepicker" style="width: 250px">
                            <input type="date" class="form-control timepicker" id="startDate" name="startDate"
                                value="{{ old('startDate') }}">
                        </div>




                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search d-none d-md-block">&nbsp;&nbsp; بحث</i>
                        </button>
                        <label for="endDate" style="margin-top:auto ">إلى تاريخ</label>
                        <div class="bootstrap-datepicker" style="width: 250px ;">
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
            <div class="card-header bg-primary text-white">
                &nbsp; سجل ايام الحضورالخاص بالموظف &nbsp; :<span style="color: black">&nbsp; {{ $user->name }} &nbsp;
                </span>
                <span class="hidden-print">
                    &nbsp;&nbsp;&nbsp;
                    بالإعتماد على التاريخ المدخل في مكان البحث المخصص للبحث ؟
                </span>
                @if (isset($startDate) and isset($endDate))
                    <span style="color: black; font-weight: bolder">من تاريخ {{ $startDate }} الي تاريخ
                        {{ $endDate }}</span>
                @endif
            </div>
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center" id="myTable">
                            <thead>
                                <tr>
                                    <th>تاريخ اليوم</th>
                                    <th>وقت الحضور</th>
                                    <th>وثت الإنصراف </th>
                                    <th> فترة العمل</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($attendances))
                                    @foreach ($attendances as $attendance)
                                        <tr>

                                            <td>{{ $attendance->date }}</td>
                                            <td> {{ $attendance->attendance_time }}</td>
                                            <td> {{ $attendance->leave_time }}</td>
                                            <th>{{ $attendance->duration_time }}</th>
                                            <td>
                                                @if ($attendance->order_status == 1)
                                                    <span class="badge bg-success">مقبول</span>
                                                @else
                                                    <span class="badge bg-danger">في حالة الانتظار</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach


                                @endif
                                @if (isset($attendances))
                                    <tr style="text-align: right">
                                        <td>
                                            عدد ساعات العمل خلل الفترة المدخلة =
                                            
                                            <span class="badge bg-info text-dark">
                                            {{ $totalTime}}
                                            </span>

                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!--/div-->


    </div>
    <div class="d-flex my-xl-auto right-content hidden-print " style="justify-content: end">
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
