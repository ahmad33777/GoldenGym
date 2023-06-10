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
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">إدارة المنتجات المنتجات</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">قائمة الفئات </a></li>
                    <li class="breadcrumb-item active"> تعديل فئة </li>
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
                        <h3>تعديل الفئة </h3>
                    </div>
                </div>
                <div class="card ">

                    <form action="{{ route('categories.update',$category->id) }}" method="POST" id="create_form">
                        @csrf
                        @method('put')
                        <div class="card-body">

                            <b>معلومات الفئة  </b>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="name" style="font-weight: 900">أسم
                                            الفئة</label>
                                        <input type="test" class="form-control" placeholder="ادخل الأسم "
                                            name="category_name" id="category_name"
                                            style="border-radius:10px ;
                                            border: 1px solid #1196db ; 
                                            font-weight: 900 ;
                                            color: black
                                            "
                                            value="{{ $category->name }}">
                                    </div>
                                    @error('category_name')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-3" style="margin-top: 26px">
                                    <button type="submit" style="border-radius:10px " class="btn btn-primary"> حفظ</button>
                                </div>



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
