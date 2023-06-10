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
            <h4 class="content-title mb-0 my-auto"><a href="{{ route('users.index') }}">الصفحة الرئيسية
                </a>/الموظفين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                إضافة موظف جديد</span>
        </div>


    </div>

</div>
<div style="width: 100%">
    <hr>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">تعديل معلومات الموظف </h3>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" id="create_form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group text-primary">
                                    <label for="name">أسم الموظف</label>
                                    <input type="test" class="form-control" placeholder="أدخل الأسم  رباعي"
                                        name="name" id="name" value="{{ $user->name }}">
                                </div>

                                @error('name')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="email"> البريد الإلكتروني</label>
                                    <input type="email" class="form-control" placeholder="أدخل البريد الإلكتروني "
                                        name="email" id="email" value="{{ $user->email }}">
                                </div>
                                @error('email')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="phone">رقم الجوال</label>
                                    <input class="form-control" type="tel" id="phone" name="phone"
                                        max="10" min="10" required value="{{ $user->phone }}"
                                        placeholder="أدخل رقم الهاتف الخاص بالموظف">
                                </div>
                                @error('phone')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="marital_status">الحالة الإجتماعية</label>
                                    <select name="marital_status" id="marital_status"
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
                            </div>
                            <div class="col-4">
                                <div class="form-group text-primary">
                                    <label for="workdays">أيام العمل ||
                                        <span class="badge bg-info  " style="color: black">
                                            {{ $user->workdays }}</span> </label>

                                    <select name="workdays[]" id="workdays" multiple="multiple"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">

                                        @foreach ($workDays as $workDay)
                                            <option value="{{ $workDay }}">
                                                {{ $workDay }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @error('workdays')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="worktimes"> أوقات العمل</label>
                                    <input class="form-control" type="tel" id="worktimes" name="worktimes" required
                                        placeholder="4:9" value="{{ $user->Worktime }}">
                                </div>
                                @error('worktimes')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="salary">الراتب</label>
                                    <input type="number" class="form-control" placeholder="أدخل الراتب الشهري"
                                        name="salary" id="salary" value="{{ $user->salary }}">
                                </div>
                                @error('salary')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="password">كلمة مرورو جديدة</label>
                                    <input type="password" class="form-control" placeholder="إدخل كلمة مرور جديد"
                                        name="password" id="password">
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group text-primary" style="width: 300px">
                                    <label for="image">صورة </label>
                                    <input class="form-control" type="file" id="image" name="image"
                                        style="height: 59px;">
                                </div>
                            </div>
                            @error('image')
                                <p style="color: red ; font-weight: bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>



            </div>

            <br>

            <div class="card-footer">
                <button type="submit" onclick="prifirmStore()" class="btn btn-primary" name="submit">تحديث
                    المعلومات </button>
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
