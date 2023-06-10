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
                    <li class="breadcrumb-item active"> تعديل منتج </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card ">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('products.update', $product->id) }}" method="POST" d="create_form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <b>معلومات المنتج الجديد</b>
                            <hr>
                            <div class="row">
                                {{-- العمود الإول  --}}
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="product_name" style="font-weight: 900">
                                            أسم المنتج
                                        </label>
                                        <input type="test" class="form-control" placeholder="أدخل أسم المنتج الجديد"
                                            name="product_name" id="product_name" style=" border: 1px solid #1196db"
                                            value="{{ $product->name }}">
                                    </div>
                                    @error('product_name')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="price" style="font-weight: 900">
                                            سعر المنتج
                                        </label>
                                        <input type="number" min="0" class="form-control"
                                            placeholder="أدخل سعر المنتج الجديد" name="price" id="price"
                                            style=" border: 1px solid #1196db" value="{{ $product->base_price }}">
                                    </div>
                                    @error('price')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="quantity" style="font-weight: 900">
                                            الكميةالمدخلة من هاذا المنتج
                                        </label>
                                        <input type="number" min="0" class="form-control"
                                            placeholder="أدخل كمية المنتج الجديد" name="quantity" id="quantity"
                                            style=" border: 1px solid #1196db" value="{{ $product->quantity }}">
                                    </div>
                                    @error('quantity')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group text-primary">
                                        <label for="image">صورة للمنتج </label>
                                        <input class="form-control" type="file" id="image" name="image"
                                            style=" border: 1px solid #1196db">
                                        @error('image')
                                            <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                        @enderror
                                    </div>



                                </div>
                                {{-- العمود الثاني --}}
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_id"
                                            style="font-weight: 900">نوع المنتج &nbsp;&nbsp;(الفئة)</label>
                                        <select name="category_id" id="category_id"
                                            class="form-select form-select-lg   form-control "
                                            style="border: 1px solid #1196db">
                                            @foreach ($categores as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($product->category_id == $category->id) selected @endif>{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group text-primary">
                                        </b> <label for="production_date" style="font-weight: 900">
                                            تاريخ الإنتاج
                                        </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="production_date"
                                                name="production_date" value="{{ $product->production_date }}"
                                                style=" border: 1px solid #1196db">
                                        </div>
                                        @error('production_date')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group text-primary">
                                        </b> <label for="expiry_date" style="font-weight: 900">
                                            تاريخ الانتهاء
                                        </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="expiry_date"
                                                name="expiry_date" value="{{ $product->expiry_date }}"
                                                style=" border: 1px solid #1196db">
                                        </div>
                                        @error('expiry_date')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col p-5 mr-5">
                                    <img src="{{ $product->image }}" width="200px"
                                        alt="productImage{{ $product->name }}">
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group text-primary">
                                        <label for="description">وصف المنتج الجديد</label>

                                        <textarea class="form-control"
                                            placeholder="أدخل بعض الكلمات التي توصف المنتج  الجديد حتى يسهل التعرف عليه من قبل البائع و المشتري "
                                            id="description" name="description" style="height: 100px ; text-align: right">
                                                @if ($product->description != null)
{{ $product->description }}
@endif
                                                
                                        </textarea>

                                    </div>
                                    @error('description')
                                        <p style="color: red ; font-weight: bold">{{ $message }}</p>
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
