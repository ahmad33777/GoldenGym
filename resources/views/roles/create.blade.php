@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    اضافة صلاحيات ومسميات وظيفية | جولد جم
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                اضافة مهنة جديد</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <!-- left column -->
        <div class="col-md-10">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">إنشاء مسمى وظيفي ومهنة جديد </h3>
                </div>
                @if ($errors->any())
                    <div class="col-6">

                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <br>
                            <i class="icon fas fa-ban">&nbsp;تنبيه !</i>
                            @foreach ($errors->all() as $error)
                                <ul>
                                    <li>
                                        {{ $error }}
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>

                @endif
                <form action="{{ route('roles.store') }}" method="post" id="create_form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">الأسم للمهنة الجديدة </label>
                            <input type="test" class="form-control" placeholder="المسى الوظيفي " name="role_name"
                                id="role_name">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="submit">إنشاء</button>
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
<!-- main-content closed -->


@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

@endsection
