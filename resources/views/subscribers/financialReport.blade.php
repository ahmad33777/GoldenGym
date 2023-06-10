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
                    <li class="breadcrumb-item"><a href="{{ route('subscribers.index') }}">قائمة المشتركين</a></li>
                    <li class="breadcrumb-item active"> تقرير مالي </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    <div class="d-flex my-xl-auto right-content hidden-print">
        <div class="pr-1 mb-3 mb-xl-0">
            <button type="button" onclick="printTable()" class="btn btn-info"><i class="fas fa-print"></i>
                &nbsp;طباعة</button>
        </div>
        <div class="pr-1 mb-3 mb-xl-0">
            <a href="" class="btn btn-success   ml-2"> <i
                    class="fas fa-file-excel"></i>&nbsp;
                تصدير</i></a>
        </div>

    </div>

    <br>
    <div class="row row-sm hidden-print">
        <div class="col-xl-12">
            <div class="card card-primary ">
                <div class="row p-3" style="text-align: center">
                    <p style="text-align: center">
                        @error('startDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror
                    </p>
                    <p style="text-align: center">
                        @error('endDate')
                        <p style="color: red ">{{ $message }}</p>
                    @enderror
                </div>
                <div class="card-body">
                    <form action="{{ route('subscriber.searchFinancialReport', $subscriber->id) }}" method="GET"
                        style="display: flex ; justify-content: space-around;">
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
            <h4>تقرير مالي للمشترك : {{ $subscriber->name }}</h4>
            <div class="card card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center" id="myTable">
                            <thead>
                                <tr>
                                     <th>نوع المدفوع</th>
                                    <th>تاريخ والوقت</th>
                                    <th>القيمة المالية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($incomings))
                                    @foreach ($incomings as $incoming)
                                        <tr>

                                             <td>{{ $incoming->incoming_type }}</td>
                                            <td>{{ $incoming->created_at }}</td>
                                            <td>{{ $incoming->incoming_value }}<span style="color: red"> ₪.</span></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" style="text-align: left ;  padding-left:100px "> <span
                                                class="bg-secondary"
                                                style="color: #FFFF ; padding: 5px ; border-radius: 8px">المجموع :
                                                {{ $total }} ₪. </span> </td>
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


@endsection

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function printTable() {
            window.print();
        }
    </script>

@endsection
