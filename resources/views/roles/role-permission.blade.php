@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الصلاحيات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="d-flex justify-content-between">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">

                    <a class="btn btn-success btn-sm" href="{{ route('permissions.create') }}"> اضافة
                        صلاحية
                        جديدة</a>
                </div>
            </div>
            <br>
        </div>
        <br>
        <br>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @foreach ($permissions as $permission)
                            <input type="checkbox" id="permission_{{ $permission->id }}"
                                onchange="priformstore({{ $roleId }}, {{ $permission->id }})"
                                @if ($permission->assigned) checked @endif>&nbsp;&nbsp;
                            <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                            <br>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        function priformstore(roleId, permissionId) {
            // console.log("Role:");
            let data = {
                permission_id: permissionId,
            };
            store('/admin/role/' + roleId + '/permissions/', data);
        }

        function store(url, data) {
            axios.post(url, data)
                .then(function(response) {
                    console.log(response);
                    if (document.getElementById('create_form') != undefined)
                        document.getElementById('create_form').reset();
                    showMessage();
                    // showToaster(response.data.message, true);
                })
                .catch(function(error) {
                    console.log("ERROR RESPONSE");
                    console.log(error.response);

                    function showMessage() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'فشل تديث الصلاحية يرجى المحاولة مرة أخرى',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    // showToaster(error.response.data.message, false);
                });
        }


        function showMessage() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'تم تحديث الصلاحية بنجاح',
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
