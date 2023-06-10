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
                الملف الشخصي / تغير كلمة المرورو</span>
        </div>


    </div>

</div>
<div style="width: 100%">
    <hr>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
@if (Session()->has('status'))
    @if (session('status') == true)
        <div class="alert alert-success fw-bold" role="alert" style="border-radius:10px ">
            تم تحديث كلمة المرورو بنجاح
        </div>
    @else
        <div class="alert alert-danger fw-bold" role="alert">
            فشلت العملية التحديث حاول لاحقاً
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
                    <h3 class="card-title">تغير كلمة المرور </h3>
                </div>

                <form action="{{ route('postChangePassword') }}" method="POST" id="create_form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group text-primary">
                                    <label for="current_password" style="font-weight: bolder">كلمة المرور
                                        الحالية</label>
                                    <input type="password" class="form-control" placeholder="كلمة المرور الحالية"
                                        name="current_password" id="current_password" style="border-radius: 10px" value="{{ old('current_password') }}">
                                </div>

                                @error('current_password')
                                  <p style="color: red ; font-weight: bold  ; font-size:10px"> <b> {{ $message }}</b></p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label style="font-weight: bolder " for="new_password">كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control" placeholder="كلمة المرور الجديدة "
                                        name="new_password" id="new_password" style="border-radius: 10px" value="{{ old('new_password') }}">
                                </div>
                                @error('new_password')
                                    <p style="color: red ; font-weight: bold ; font-size:10px">{{ $message }}</p>
                                @enderror

                                <div class="form-group text-primary">
                                    <label style="font-weight: bolder " for="new_password_confirmation">تأكيد كلمة
                                        المروور</label>
                                    <input class="form-control" type="password" id="new_password_confirmation"
                                       value="{{ old('new_password_confirmation') }}"  name="new_password_confirmation" placeholder="  ادخل كلمة المرور مرة اخرى" style="border-radius: 10px">
                                </div>
                                @error('new_password_confirmation')
                                    <p style="color: red ; font-weight: bold ; font-size:10px">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>



                    </div>

                    <br>

                    <div class="card-footer">
                        <button type="submit"   class="btn btn-primary" name="submit">تعين
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
