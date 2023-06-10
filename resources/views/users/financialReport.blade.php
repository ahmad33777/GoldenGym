@extends('layouts.master')
@section('css')

    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }
        }
    </style>
@section('title')
    Golden Gym
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="row hidden-print" id="links">
    <div class="col">
        <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">قائمة الموظفين</a></li>
                <li class="breadcrumb-item active"> تقرير مالي للموظف </li>
            </ol>
        </nav>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row row-sm">

    <div class="col-md-12 col-xl-12">
        <div class="row row-sm hidden-print">
            <div class="col-xl-12">
                <div class="card card-success ">
                    <div class="row p-3" style="display: flex ; justify-content: space-around;">
                        @error('startDate')
                            <p style="color: red ">{{ $message }}</p>
                        @enderror

                        @error('endDate')
                            <p style="color: red ">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee.financialReportSearch', $user->id) }}" method="GET"
                            style="display: flex ; justify-content: space-around;">
                            <label for="startDate" style="margin-top:auto ">من تاريخ</label>
                            <div class="bootstrap-datepicker" style="width: 250px">
                                <input type="date" class="form-control timepicker" id="startDate" name="startDate"
                                    value="{{ old('startDate') }}">
                            </div>




                            <button type="submit" class="btn btn-success">
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
        <div class="card-header bg-success text-white">
            &nbsp; تقرير مالي خاص بالموظف &nbsp; :<span style="color: black">&nbsp; {{ $user->name }} &nbsp;
            </span>
            <span class="hidden-print">
                &nbsp;&nbsp;&nbsp;
                بالإعتماد على التاريخ المدخل في مكان البحث المخصص للبحث ؟
            </span>
            @if (isset($startDate) and isset($endDate))
                <span style="color: black; font-weight: bolder"> &nbsp;&nbsp;&nbsp; {{ $startDate }} &nbsp; - &nbsp;
                    {{ $endDate }}</span>
            @endif
        </div>
        <div class=" main-content-body-invoice">

            <div class="card card-invoice">
                <div class="card-body">
                    <div class="row" style="display: flex ; justify-content: space-between">
                        <h1 class="invoice-title pr-5">تقرير مالي </h1>
                        <div class="invoice-header">
                            <div class="billed-from">
                                <h1 class="invoice-title">Golden Gym</h1>
                                <h6 style="color:#544d4d">التاريخ : {{ date('Y-m-d   الوقت  :  h:i:s') }}</h6>
                            </div>
                        </div>
                    </div>


                    <div class="row mg-t-20">
                        <div class="col-4">
                            <label class="tx-gray-600">معلومات الموظف </label>
                            <div class="billed-to">
                                <h6>اسم الموظف : {{ $user->name }}</h6>
                                <p>البريد الإلكتروني: {{ $user->email }}</p>
                                <p>رقم الهاتف : {{ $user->phone }}</p>
                                <p> الحالة الإجتماعية : {{ $user->marital_status }}</p>
                                <p> أيام العمل : {{ $user->workdays }} </p>
                                <p> الراتب بدون خصومات : {{ $user->salary }} - شيكل </p>
                            </div>
                        </div>

                        <div class="col-4">
                            <label class="tx-gray-600">المزير من المعلومات </label>
                            @if (isset($numDays))
                                <p style="font-weight: 900" class="invoice-info-row"><span>عدد أيام الحضور : </span>
                                    <span>{{ $numDays }}  يوم </span>
                                </p>
                            @endif

                            <p class="invoice-info-row" style="font-weight: 900"><span>مجموع ساعات العمل : </span>
                                     {{ $totalTime  ?? null}}     ساعة 
                             </p>

                        </div>
                        <br>
                    </div>

                    <hr class="mg-b-40">
                    <button type="button" onclick="printTable()" class="btn btn-info hidden-print"><i
                            class="fas fa-print"></i>
                        &nbsp;طباعة</button>

                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script>
    function printTable() {
        window.print();
    }
</script>

@endsection
