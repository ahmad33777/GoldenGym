@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> <a href="{{ route('home') }}">الصفحة الرئيسية
                    </a>/</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    مواعيد العمل والشفتات </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert alert-success fw-bold" role="alert">
                نجحت العمليةالأضافة
            </div>
        @else
            <div class="alert alert-danger fw-bold" role="alert">
                فشلت العملية العمليةالأضافة
            </div>
        @endif
    @endif

    @if (Session()->has('statusUpdate'))
        @if (session('statusUpdate') == true)
            <div class="alert alert-success fw-bold" role="alert">
                    نجحت العملية
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

                                <button type="button" class="btn btn-primary  btn-sm" data-toggle="modal"
                                    data-target="#addnewschedule">
                                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    اضافة موعد عمل جديد
                                </button>

                            </div>
                        </div>
                        <br>
                    </div>
                    <form action="" method="GET">
                        <div style=" float: left;">
                            <div class="main-header-center">
                                <input class="form-control" placeholder="أدخل من أجل البحث ؟" type="search" name="search"
                                    id="search">
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
                                    <th>أسم الشفت</th>
                                    <td>وقت بداية الدوام</td>
                                    <td>وقت نهاية الدوام</td>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($schedules as $schedule)
                                        <td>{{ $schedule->name }}</td>
                                        @php
                                            $temp_in = explode(':', $schedule->time_in);
                                            $hour_in = $temp_in[0]; // ساعات
                                            $minutes_in = $temp_in[1];
                                            
                                            $temp_out = explode(':', $schedule->time_out);
                                            $hour_out = $temp_out[0]; // ساعات
                                            $minutes_out = $temp_out[1];
                                        @endphp
                                        <td>
                                            @if ($schedule->type === 'AM')
                                                <span class="badge bg-success text-white"> AM</span>
                                            @else
                                                <span class="badge bg-success text-white"> PM</span>
                                            @endif
                                            {{ $hour_in }}:{{ $minutes_in }}
                                        </td>

                                        <td>
                                            @if ($schedule->type === 'AM')
                                                <span class="badge bg-success text-white"> PM</span>
                                            @else
                                                <span class="badge bg-success text-white"> AM</span>
                                            @endif
                                            {{ $hour_out }}:{{ $minutes_out }}
                                        </td>

                                        <td>
                                            {{-- <a href="" data-toggle="modal" data-target="#editModel"
                                                class="btn btn-primary btn-sm edit btn-flat">
                                                <i class='fa fa-edit'></i></a>
                                                 --}}
                                            <button id="editBtn" type="button" value="{{ $schedule->id }}"
                                                class="btn btn-primary btn-sm edit btn-flat editbtn"><i
                                                    class='fa fa-edit'></i></a></button>

                                            <a href="#" onclick="confirmDestroy({{ $schedule->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </a>
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


    <!-- Modal -->
    <!-- Add -->
    <div class="modal fade" id="addnewschedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                        موعد عمل جديد
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group text-primary">
                            <label for="name"> <span style="color: red;  font-weight: bolder">* </span> الأسم</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nameHelp"
                                name="name" placeholder=" أسم الشفت">
                            <small id="nameHelp" class="form-text text-muted">
                                @error('name')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>
                        <div class="form-group text-primary">
                            <label for="time_in"> <span style="color: red;  font-weight: bolder">* </span> وقت بداية
                                العمل</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="time_in" name="time_in">
                            </div>
                            <small id="nameHelp" class="form-text text-muted">
                                @error('time_in')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>

                        <div class="form-group text-primary">
                            <label for="time_out"> <span style="color: red;  font-weight: bolder">* </span> وقت نهاية
                                العمل</label>
                            <div class="bootstrap-timepicker">
                                <div class="bootstrap-timepicker">
                                    <input type="time" class="form-control timepicker" id="time_out"
                                        name="time_out">
                                </div>
                            </div>
                            <small id="nameHelp" class="form-text text-muted">
                                @error('time_out')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




    {{-- update  --}}
    <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                        تحديث معلومات
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/schedules/update') }}" method="POST">
                    <input type="hidden" id="scheduleID" name="scheduleID" />
                    @method('PUT')
                    @csrf
                    
                    <div class="modal-body ">
                        <div class="form-group text-primary">
                            <label for="name"> <span style="color: red;  font-weight: bolder">* </span>
                                الأسم</label>
                            <input type="text" class="form-control" id="editname" aria-describedby="nameHelp"
                                name="name" placeholder=" أسم الشفت">
                            <small id="nameHelp" class="form-text text-muted">
                                @error('name')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>
                        <div class="form-group text-primary">
                            <label for="time_in"> <span style="color: red;  font-weight: bolder">* </span> وقت بداية
                                العمل</label>
                            <div class="bootstrap-timepicker">
                                <input type="time" class="form-control timepicker" id="edit_time_in" name="time_in"
                                    value=" ">
                            </div>
                            <small id="nameHelp" class="form-text text-muted">
                                @error('time_in')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>

                        <div class="form-group text-primary">
                            <label for="time_out"> <span style="color: red;  font-weight: bolder">* </span> وقت نهاية
                                العمل</label>
                            <div class="bootstrap-timepicker">
                                <div class="bootstrap-timepicker">
                                    <input type="time" class="form-control timepicker" id="edit_time_out" name="time_out"
                                         >
                                </div>
                            </div>
                            <small id="nameHelp" class="form-text text-muted">
                                @error('time_out')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>
                </form>

            </div>
        </div>
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
            axios.delete('/admin/schedules/' + id)
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
        $(document).ready(function() {
            $(document).on('click', '#editBtn', function() {
                var schedule_id = $(this).val();
                // alert(schedule_id);
                $('#editModel').modal('show');

                $.ajax({
                    type:'GET',
                    url:'/admin/schedules/'+schedule_id+'/edit',
                    success :  function(response){
                        // console.log(response);
                        $('#editname').val(response.schedule.name);
                        $('#edit_time_in').val(response.schedule.time_in);
                        $('#edit_time_out').val(response.schedule.time_out);
                        $('#scheduleID').val(response.schedule.id);

                    }
                });
            });
        });
    </script>


@endsection
