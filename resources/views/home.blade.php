@extends('layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <!-- Maps css -->
@section('title')
    الصفحة الرئيسية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصفحة الرئيسية</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الأحصائيات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        @role(['admin', 'accountant'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-primary-gradient text-white ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">المشتركين</span>
                                    <h2 class="text-white mb-0">{{ $subscribers }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('subscribers.index') }}" style="color: white">
                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>

                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-danger-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">الموظفين</span>
                                    <h2 class="text-white mb-0">{{ $employees }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('users.index') }}" style="color: white">

                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-success-gradient text-white">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">المدربين</span>
                                    <h2 class="text-white mb-0">{{ $trainers }}</h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('trainers.index') }}" style="color: white">
                                    <div class="icon1 mt-2 text-center">
                                        <i class="fe fe-users tx-40"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin'])
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-warning-gradient text-white">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">الواردات الكلية </span>
                                    <h2 class="text-white mb-0"> {{ $incomings }} </h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fas fa-dollar-sign tx-40"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role(['admin', 'accountant'])
            <div class="col-sm-12 col-lg-6 col-xl-3">
                <div class="card card-img-holder">
                    <div class="card-body list-icons">
                        <div class="clearfix">
                            <div class="float-right text-right">
                                <p class="card-text text-muted mb-1">المصروفات اليومية</p>
                                <h3>{{ $dailyExpenses }} ₪.</h3>
                            </div>
                            <div class="float-left  mt-2">
                                <span class="text-primary ">
                                    <i class="si si-credit-card tx-30"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-xl-3">
                <div class="card card-img-holder">
                    <div class="card-body list-icons">
                        <div class="clearfix">
                            <div class="float-right text-right">
                                <p class="card-text text-muted mb-1">الصادرات اليومية</p>
                                <h3> 100 ₪. </h3>
                            </div>
                            <div class="float-left  mt-2">
                                <span class="text-primary ">
                                    <i class="si si-credit-card tx-30"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endrole
        @role(['vendor'])
        @endrole


        @role('vendor')
            <div class="col-xl-3 col-lg-6 col-sm-6 col-md-6">
                <div class="card text-center">
                    <div class="card-body ">
                        @php
                            $CategoryCOuntr = App\Models\Category::count();
                        @endphp
                        <h6 class="mb-1 text-muted">عدد الفئات الموجودة</h6>
                        <h3 class="font-weight-semibold">{{ $CategoryCOuntr }} فئات</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4" style=" border-radius:8px ; color: white">
                <div class="card">
                    <div class="card-body" style="background-color:blue ; border-radius:8px ">
                        <form>
                            <div class="mb-3">
                                <label for="" class="form-label" style=" color: white">Email address</label>
                                <input type="text" class="form-control" id=" " aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="" style=" color: white" class="form-label">Password</label>
                                <input type="" class="form-control" id="">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endrole
    </div>







    </div>
    <!-- Container closed -->
@endsection
@section('js')


@endsection
