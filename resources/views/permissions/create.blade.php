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
            <h4 class="content-title mb-0 my-auto">الإعادادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                صلاحية جديد</span>
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
                    <h3 class="card-title">إضافة صلاحية جديدة</h3>
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
                <form action="{{ route('permissions.store') }}" method="post" id="create_form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name"> أسم الصلاحية الجديدة </label>
                            <input type="test" class="form-control" placeholder="الصلاحية" name="permission_name"
                                id="permission_name">
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
@endsection
