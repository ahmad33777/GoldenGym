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
                    <li class="breadcrumb-item active"> الصادرات والواردات</li>
                    <li class="breadcrumb-item active"> قسم الواردات</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')



    <p style="text-align: center">
        @error('startDate')
        <p style="color: red " style="text-align: center">{{ $message }}</p>
    @enderror

    @error('endDate')
        <p style="color: red " style="text-align: center">{{ $message }}</p>
    @enderror
    </p>
    <div class="row row-sm hidden-print">
        <div class="col-xl-12">
            <div class="card">




                <div class="card-body">
                    <form action="{{ route('incomings.index') }}" method="GET"
                        style="display: flex ; justify-content: space-around;">
                        <label for="startDate" style="margin-top:auto ">من تاريخ</label>
                        <div class="bootstrap-datepicker" style="width: 350px">
                            <input type="date" class="form-control timepicker" id="startDate" name="startDate"
                                value="{{ old('startDate') }}">
                        </div>


                        <button type="submit" class="btn btn-primary">
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
                @if (isset($startDate) and isset($endDate))
                    <div class="card-header bg-info text-white">
                        <p>تقرير بالواردات من تاريخ {{ $startDate }} الي تاريخ {{ $endDate }}</p>
                    </div>
                @endif


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <th>نوع الوارد</th>
                                    <th>قيمة الوارد</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>الموظف المدخل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($incomins))
                                    @foreach ($incomins as $incomin)
                                        <tr>
                                            <td>
                                                <span class="badge bg-info text-dark">{{ $incomin->incoming_type }}</span>
                                            </td>
                                            <td>{{ $incomin->incoming_value }} ₪.</td>
                                            <td>{{ $incomin->incoming_date }} </td>
                                            <td>{{ $incomin->emp->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            {!! $incomins->withQueryString()->links('pagination::bootstrap-5') !!}

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
