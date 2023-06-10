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
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">قائمة الموظفين</a></li>
                <li class="breadcrumb-item active"> اضافة موظف جديد</li>
            </ol>
        </nav>
    </div>
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
                    <h3 class="card-title">إضافة موظف جديد</h3>
                </div>

                <form action="{{ route('users.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group text-primary">
                                    <label for="name">أسم الموظف</label>
                                    <input type="test" class="form-control" placeholder="أدخل الأسم  رباعي"
                                        name="name" id="name" {{ old('name') }}  value="{{ old('name') }}">
                                </div>

                                @error('name')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="email"> البريد الإلكتروني</label>
                                    <input type="email" class="form-control" placeholder="أدخل البريد الإلكتروني "
                                        name="email" id="email"   value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="phone">رقم الجوال</label>
                                    <input class="form-control" type="tel" id="phone" name="phone"
                                        max="10" min="10"    
                                        placeholder="أدخل رقم الهاتف الخاص بالموظف" value="{{ old('phone') }}">
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
                                            <option value="{{ $st }}">{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('marital_status')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-4">
                                <div class="form-group text-primary">
                                    <label for="workdays">أيام العمل</label>
                                    <select name="workdays[]" id="workdays" multiple="multiple"  
                                        class="form-select form-select-lg mb-2 text-primary form-control ">
                                        @foreach ($workDays as $workDay)
                                            <option value="{{ $workDay }}">{{ $workDay }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                @error('workdays')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="worktimes"> أوقات العمل</label>
                                    <input class="form-control" type="tel" id="worktimes" name="worktimes"   
                                        placeholder="(8:00 - 9:00)" style="text-align: right" value="{{ old('worktimes') }}">
                                </div>
                                @error('worktimes')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                                <div class="form-group text-primary">
                                    <label for="salary">الراتب</label>
                                    <input type="number" class="form-control" placeholder="أدخل الراتب الشهري" 
                                        name="salary" id="salary">
                                </div>
                                @error('salary')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror

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
            {{-- <div class="card-footer">
                <div class="card-header">
                    <div class="row">
                        <h3> منح صلاحية :</h3>
                        <div class="col-6">
                            <select name="role" id="role"
                                class="form-select form-select-lg mb-3 text-primary form-control ">
                                <option value="" disabled selected hidden>إختار صلاحية ليتم منحها للموظف الجديد
                                </option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>

            </div> --}}
            <br>

            <div class="card-footer">
                <button type="submit" onclick="prifirmStore()" class="btn btn-primary"
                    name="submit">إنشاء</button>
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

{{-- <script>
    function prifirmStore() {
        let data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            marital_status: document.getElementById('marital_status').value,
            workdays: document.getElementById('workdays').value,
            Worktime: document.getElementById('worktimes').value,
            salary: document.getElementById('salary').value,
            password: document.getElementById('password').value,
            image: document.getElementById('image').value,
            role: document.getElementById('role').value
        }
        store('/admin/users', data);
    }

    function store(url, data) {
        axios.post(url, data)
            .then(function(response) {
                console.log(response);
                if (document.getElementById('create_form') != undefined)
                    document.getElementById('create_form').reset();

                function showMessage() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'تمت عملية الأضافة بنجاح مع منح الصلاحية',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
            .catch(function(error) {
                console.log("ERROR RESPONSE");
                console.log(error.response);

                function showMessage(data) {
                    function showMessage(data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'يرجى المحاولة مرة أخري والتأكد من البيانات',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
    }
</script> --}}
@endsection
