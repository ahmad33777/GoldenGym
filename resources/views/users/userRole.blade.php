@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@stop

 

@section('page-header')
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">قائمة الموظفين</a></li>
                    <li class="breadcrumb-item active">صلاحيات
                        الموظف</li>
                </ol>
            </nav>
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
    <div class="row">
        <div class="col-xl-8">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <p>أسم الموظف : {{ $user->name }}</p>
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <th>أسم الصلاحية</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($user->roles as $role)
                                    <tr>
                                        <td style="font-weight:bold">
                                            {{ $role->name }}
                                        </td>

                                        <td><a href="#"
                                                onclick="confirmDestroy({{ $role->id }}, {{ $user->id }}, this)"
                                                class="btn btn-danger
                                                btn-sm">حذف&nbsp;<i
                                                    class="fas fa-trash"> </i>
                                            </a></td>
                                    </tr>
                                @endforeach






                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">

                <div class="card-body">
                    @if (Session()->has('status'))
                        @if (session('status') == true)
                            <div class="alert alert-success fw-bold" role="alert">
                                تم منح الصلاحية للموظف الحالي
                            </div>
                        @else
                            <div class="alert alert-danger fw-bold" role="alert">
                                فشلت العملية
                            </div>
                        @endif
                    @endif
                    <p>كل الصلاحيات </p>

                    <form action="{{ route('role.add', $user->id) }}" method="POST">
                        @csrf
                        <div class="form-group text-primary">
                            <select name="roles[]" id="roles" multiple="multiple"
                                class="form-select form-select-lg mb-3 text-primary form-control ">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>
                        <div class="card-footer">
                            <button type="submit" onclick="prifirmStore()" class="btn btn-primary" name="submit">منح
                                الصلاحية</button>
                        </div>
                    </form>



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
        function confirmDestroy(roleId, userId, td) {
            Swal.fire({
                title: 'هل أنت متأكد ؟',
                text: "  لا يمكن التراجع عن عملية   تحرير الموظف من  الصلاحية",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'تحرير',
                cancelButtonText: 'إلغاء',
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(roleId, userId, td);
                }
            });
        }

        function destroy(roleId, userId, td) {

            axios.delete('/admin/employees/roles/remove/' + roleId + '/' + userId)
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


        function prifirmStore() {
            let data = {
                roles: document.getElementById('roles').value,
            }


            store('admin/employees/roles/addRole', data);
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
    </script>

@endsection
