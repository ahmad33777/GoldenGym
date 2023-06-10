@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <style>
        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #084cdf;
            padding: 10px 10px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background: #0d45a5;
        }
    </style>
@section('title')
    Golden Gym
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الأعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                الملف الشخصي </span>
        </div>


    </div>

</div>
<div style="width: 100%">
    <hr>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
@if (Session()->has('statusUpdate'))
    @if (session('statusUpdate') == true)
        <div class="alert alert-success fw-bold" role="alert" style="border-radius:10px ">
            تمت تحديث معلومات الملف الشخصي
        </div>
    @else
        <div class="alert alert-danger fw-bold" role="alert">
            فشلت العملية التحديث
        </div>
    @endif
@endif
<div class="container-fluid">

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> تحديث معلومات الملف الشخصي </h3>
                </div>

                <form action="{{ route('profiles.update', $user->id) }}" method="POST" id="create_form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">

                                <div class="form-group text-primary">
                                    <label for="name" style="font-weight: bolder">الأسم</label>
                                    <input style="font-weight: bolder" type="test" class="form-control"
                                        placeholder="أدخل الأسم  رباعي" name="name" id="name"
                                        value="{{ $user->name }}">
                                </div>

                                @error('name')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="email" style="font-weight: bolder"> البريد الإلكتروني</label>
                                    <input style="font-weight: bolder" type="email" class="form-control"
                                        placeholder="أدخل البريد الإلكتروني " name="email" id="email"
                                        value="{{ $user->email }}">
                                </div>
                                @error('email')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="phone" style="font-weight: bolder">رقم الهاتف </label>
                                    <input style="font-weight: bolder" class="form-control" type="tel"
                                        id="phone" name="phone" max="10" min="10" required
                                        value="{{ $user->phone }}" placeholder="أدخل رقم الهاتف الخاص بالموظف">
                                </div>
                                @error('phone')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="marital_status" style="font-weight: bolder">الحالة الإجتماعية</label>
                                    <select style="font-weight: bolder" name="marital_status" id="marital_status"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">
                                        <option value="" disabled selected hidden>إختار الحالة الإجتماعية</option>
                                        @foreach ($status as $st)
                                            <option
                                                value="{{ $st }}"@if ($st == $user->marital_status) selected @endif>
                                                {{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('marital_status')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror

                                <div class="form-group text-primary">
                                    <label for="image" style="font-weight: bolder"> صورة الشخصية جديد</label>
                                    <input class="form-control" type="file" id="image" name="image"
                                        style="height: 59px;">
                                </div>

                                @error('image')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror


                            </div>
                            <div class="col-2">
                                <img style="margin-right: 80px" src="{{ asset('assets/img/faces/6.jpg') }}"
                                    alt="">
                            </div>

                        </div>



                    </div>

                    <br>

                    <div class="card-footer">
                        <button type="submit" onclick="prifirmStore()" class="btn btn-primary" name="submit">حفظ
                        </button>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->


@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

@endsection
