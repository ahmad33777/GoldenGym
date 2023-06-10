@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> <a href="{{ route('users.index') }}">الصفحة الرئيسية
                    </a>/</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    قائمة الموظفين </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
     @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert alert-success fw-bold" role="alert">
                تمت اضافة الموظف الجديد ومنحه الصلاحية
            </div>
        @else
            <div class="alert alert-danger fw-bold" role="alert">
                فشلت العملية
            </div>
        @endif
    @endif
    @if (Session()->has('statusUpdate'))
        @if (session('statusUpdate') == true)
            <div class="alert alert-success fw-bold" role="alert">
                تمت تحديث معلومات الموظف وتحديث صلاحياته
            </div>
        @else
            <div class="alert alert-danger fw-bold" role="alert">
                فشلت العملية التحديث
            </div>
        @endif
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
                                <a class="btn btn-primary  " href="{{ route('users.create') }}"><i
                                        class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    اضافة موظف جديد</a>

                            </div>
                        </div>
                        <br>
                    </div>
                    <form action="{{ route('users.search') }}" method="GET">
                        <div style=" float: left;">
                            <div class="main-header-center">
                                <input class="form-control" placeholder="أدخل من أجل البحث ؟" type="search" name="search"
                                    id="search" style="width: 500px">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search d-none d-md-block"></i>
                                </button>
                            </div>
                        </div>
                    </form>


                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>أسم الموظف</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>الراتب</th>
                                    <th>الحالة الإجتماعية</th>
                                    <th>أيام العمل</th>
                                    <th>أوقات العمل</th>
                                    <th>الصلاحية</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="dropdownSub">
                                                <button onclick="showD()" class="dropbtn">::</button>
                                                <div id="myDropdown" class="dropdown-content">
                                                    <a href="{{ route('financialReport', $user->id) }}">تقرير مالي
                                                    </a>
                                                    <a href="{{ route('attendanceReport.index', $user->id) }}">
                                                        تقرير حضور وإنصراف
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->salary }} : $</td>
                                        <td>{{ $user->marital_status }}</td>
                                        @if (!empty($user->workdays))
                                            <td>{{ $user->workdays }}</td>
                                        @else{
                                            <td>---------</td>
                                        @endif

                                        @if (!empty($user->Worktime))
                                            <td>{{ $user->Worktime }}</td>
                                        @else
                                            <td>---------</td>
                                        @endif

                                        <td>

                                            <a href="{{ route('employees.roles', $user->id) }}">
                                                <span class="badge bg-success text-white">

                                                    {{ $user->roles_count }}
                                                </span>
                                            </a>
                                        </td>



                                        <td>
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <a href="#" onclick="confirmDestroy({{ $user->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </a>



                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>

                    </div>
                    <br>
                    <br>
                    {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}

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
            axios.delete('/admin/users/' + id)
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

    <script>
        function showD() {
            document.getElementById("myDropdown").classList.toggle("show");

        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }




        // Close the dropdown menu if the user clicks outside of it
    </script>


@endsection
