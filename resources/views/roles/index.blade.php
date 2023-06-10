@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصفحة الرئيسية</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المسميات الوظيفية </span>
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
                                 
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addnewRole">
                                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    اضافة مهنة جديدة
                                </button>
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
                                    <th>المسمى الوظيفي</th>
                                    <th> عدد الصلاحيات المعطى</th>

                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td style="font-weight:bold">{{ $role->name }}</td>

                                        <th>
                                            <a href="{{ route('role.permissions.index', $role->id) }}"class="badge bg-primary"
                                                style="color: white">
                                                <span style="font-weight:bold; ">{{ $role->permissions_count }}</span> /
                                                صلاحيات

                                            </a>

                                        </th>

                                        <td>

                                            <a href="#" onclick="confirmDestroy({{ $role->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> &nbsp;حذف</a>
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
    <div class="modal fade" id="addnewRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                           مسمى وظيفي جديد  
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf

                    <div class="modal-body ">
                        <div class="form-group text-primary">
                            <label for="name"> <span style="color: red;  font-weight: bolder">* </span> المسمى الوظيفي</label>
                            <input type="text" class="form-control"id="role_name" aria-describedby="nameHelp"
                            name="role_name" placeholder="المسى الوظيفي " required>
                                 
                            <small id="nameHelp" class="form-text text-muted">

                            </small>
                        </div>
                         

                         





                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">إنشاء</button>
                    </div>
                </form>

            </div>
        </div>
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
            axios.delete('/admin/roles/' + id)
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
