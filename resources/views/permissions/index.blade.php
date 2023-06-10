@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الاعدادات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الصلاحيات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    {{-- main content --}}

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <br>
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">

                                <a class="btn btn-primary btn-sm" href="{{ route('permissions.create') }}"> اضافة صلاحية
                                    جديدة</a>
                            </div>
                        </div>
                        <br>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <th>أسم الصلاحية</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td style="font-weight:bold">{{ $permission->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"
                                                    onclick="confirmDestroy({{ $permission->id }}, this)"></i> &nbsp;&nbsp;حذف</a>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        function confirmDestroy(id, td) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لا يمكن التراجع عن عملية الحذف",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم',
                cancelButtonText: 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, td);
                }
            });
        }

        function destroy(id, td) {
            axios.delete('/admin/permissions/' + id)
                .then(function(response) {
                    // handle success 2xx 3xx
                    console.log(response.data);
                    td.closest('tr').remove();
                    showMessage(response.data);
                })
                .catch(function(error) {
                    // handle error 4xx 5xx
                    console.log(error.response);
                    showMessage(error.response.data);
                })
                .then(function() {
                    // always executed
                });
        }

        function showMessage(data) {
            Swal.fire({
                position: 'top-end',
                icon: data.icon,
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>

@endsection
