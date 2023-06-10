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
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">قائمة الفئات</a></li>
                <li class="breadcrumb-item active"> تقرير بكل المنتجات </li>
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
        <div class="card-header bg-primary text-white">
            <p>تقرير بكل المنتجات الموجودة في الفئة : <span style="color: #000"> {{ $category->name }}</span></p>
        </div>
        <div class=" main-content-body-invoice">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <h1 class="invoice-title">Golden Gym</h1>
                        <div class="billed-from">
                            <h6>التاريخ : {{ date('Y-m-d    -    الوقت  h:i:s') }}</h6>
                        </div>
                    </div>

                    <div class="row mg-t-20">
                        <div class="col-3">
                            <div class="billed-to">
                                <h6>أسم الفئة : {{ $category->name }} </h6>
                                <h6>عدد المنتجات الموجودة = <span class="badge bg-warning text-dark">
                                        {{ $category->products_count }}</span> منتج</h6>
                            </div>
                        </div>
                        <div class="col">
                            <label class="tx-gray-600">كل الأصناف الموجودة في الفئة </label>
                            <table class="table  table-sm">
                                <tr>
                                    <th>أسم المنتج</th>
                                    <th>الكمية</th>
                                    <th> السعر الاساسي</th>
                                    <th style="color: red">نسبة الخصم</th>
                                    <th>تاريخ الإنتهاء</th>
                                    <th></th>
                                </tr>
                                @foreach ($category->products as $product)
                                    <tr>
                                        <td>{{ $product->name }} </td>
                                        <td> {{ $product->quantity }}</td>
                                        <td> {{ $product->base_price }}</td>
                                        <td>{{ $product->discount  ?? null}} %</td>
                                        <td>{{ $product->expiry_date }} </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>

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
