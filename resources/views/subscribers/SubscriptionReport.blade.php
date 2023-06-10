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
                <li class="breadcrumb-item"><a href="{{ route('subscribers.index') }}">قائمة المشتركين</a></li>
                <li class="breadcrumb-item active"> تقرير الإشتراك </li>
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
        <div class=" main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">Golden Gym</h1>
                        <div class="billed-from">
                            <h6>التاريخ : {{ date('Y-m-d h:i:s') }}</h6>
                        </div>
                    </div>

                    <div class="row mg-t-20">
                        <div class="col-4">
                            <div class="billed-to">
                                <h6>اسم المشترك : {{ $subscriber->name }}</h6>
                                <p>رقم الهاتف : {{ $subscriber->phone }}</p>
                                <p>العمر: {{ $subscriber->age }}</p>
                                <p> الوزن: {{ $subscriber->weight }}</p>
                                <p> الطول : {{ $subscriber->height }}</p>
                                <p> الحالة الإجتماعية : {{ $subscriber->marital_status }}</p>
                                <p> الحالة الصحية : {{ $subscriber->health_status }}</p>
                                <p> المديونية : {{ $subscriber->indebtedness }} شيكل</p>
                            </div>
                        </div>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات الإشتراك</label>
                            <p class="invoice-info-row"><span>نوع الإشتراك : </span>
                                <span>{{ $subscriber->subscription->subscription_type }}</span>
                            </p>
                            <p class="invoice-info-row"><span>سعر الإشتراك : </span>
                                <span>{{ $subscriber->subscription->subscription_price }} - شيكل</span>
                            </p>
                            <p class="invoice-info-row"><span> عدد التمارين :</span>
                                <span>{{ $subscriber->subscription->number_exercises }} - تمرين </span>
                            </p>
                        </div>
                        <br>
                        <div class="col-md">
                            <label class="tx-gray-600">معلومات المدرب</label>
                            <p class="invoice-info-row"><span> اسم المدرب : </span>
                                <span>{{ $subscriber->trainer->name }}</span>
                            </p>
                            <p class="invoice-info-row"><span>البريد الإلكتروني : </span>
                                <span>{{ $subscriber->trainer->email }}</span>
                            </p>

                            <p class="invoice-info-row"><span>رقم الهاتف : </span>
                                <span>{{ $subscriber->trainer->phone }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="mg-b-40">
                    <button type="button" onclick="printTable()" class="btn btn-info hidden-print"><i class="fas fa-print"></i>
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
