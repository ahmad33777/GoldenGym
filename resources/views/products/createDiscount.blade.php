@extends('layouts.master')
@section('title')
    Golden Gym
@stop
@section('page-header')
    <!-- breadcrumb -->
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">إدارة المنتجات المنتجات</a></li>
                    <li class="breadcrumb-item active"> قائمة المنتجات</li>
                    <li class="breadcrumb-item active"> اضافة خصم </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card-header bg-primary text-white">
                    <div>
                        <h3>خصم جديد</h3>
                    </div>
                </div>
                <div class="card ">
                   
                    <form action="{{ route('products.discount', $product->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <b>إضافة خصم على منتج &nbsp;: &nbsp; <span style="color: green">{{ $product->name }}
                                    &nbsp;&nbsp;</span> <span class="badge bg-light text-dark"> السعر الاساسي للمنتج =
                                    {{ $product->base_price }} ₪. </span></b>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="discount" style="font-weight: 900">
                                             نسبة الخصم   %
                                        </label>
                                        <input type="number" class="form-control" placeholder="أدخل نسبة الخصم"
                                            name="discount" id="discount" style=" border: 1px solid #1196db"
                                            value="{{ $product->discount }}">
                                    </div>
                                    @error('discount')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="" style="font-weight: 900">
                                            السعر بعد الخصم
                                        </label>
                                        <input type="number" class="form-control" placeholder="السعر بعد الخصم"
                                            name="price_after_discount" id="price_after_discount" disabled
                                            style=" border: 1px solid #1196db" value="{{ $product->price_after_discount }}">
                                    </div>
                                    @error('price_after_discount')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3" style="margin-top: 26px">
                                <button type="submit" style="border-radius:10px " class="btn btn-primary"> حفظ</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>

@endsection
