@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
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
                    قائمة المدربين </span>
            </div>
        </div>
    </div>

    <!-- breadcrumb -->
@endsection
@section('content')
    {{-- main content --}}
    {{-- الرسالة عند الاضافة  --}}
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert alert-success fw-bold" role="alert">
                تمت اضافة المدرب الجديد
            </div>
        @else
            <div class="alert alert-danger fw-bold" role="alert">
                فشلت العملية
            </div>
        @endif
    @endif
    @if ($errors->any())
        <div class="alert alert-danger fw-bold" role="alert">
            فشلت العملية من فضلك حاول مرة أخرى
        </div>
    @endif
    {{-- الرسالة عند التعديل --}}
    @if (Session()->has('statusUpdate'))
        @if (session('statusUpdate') == true)
            <div class="alert alert-success fw-bold" role="alert">
                تمت تحديث معلومات المدرب
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
                    <div class="row" style="display: flex;  justify-content: space-between">
                        <form action="{{ route('trainers.search') }}" method="GET">
                            <div style=" float: left; width: 500px">
                                <div class="main-header-center">
                                    <input class="form-control" placeholder="البحث عن طريق الإسم  , رقم الهاتف "
                                        type="search" name="search" id="search">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search d-none d-md-block"></i>
                                    </button>

                                </div>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">

                                    <button type="button" class="btn btn-primary   " data-toggle="modal"
                                        data-target="#trainerid">
                                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                        اضافة مدرب جديد
                                    </button>

                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <th>أسم المدرب</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <td>العمر</td>
                                    <th>الحالة الإجتماعية</th>
                                    <th>الشفت</th>
                                    <th>العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    <tr>
                                        <td>{{ $trainer->name }}</td>
                                        <td>{{ $trainer->email }}</td>
                                        <td>{{ $trainer->phone }}</td>
                                        <td>{{ $trainer->age }} سنة</td>
                                        <td>{{ $trainer->marital_status }}</td>
                                        <td>
                                            <a href="{{ route('schedules.index') }}" style="color: black">
                                                <span class="badge bg-info">
                                                    {{-- return first schedules the trainer  is have --}}
                                                    @if (isset($trainer->schedules->first()->name))
                                                        {{ $trainer->schedules->first()->name }}
                                                    @endif

                                                </span>
                                            </a>


                                        </td>
                                        <td>
                                            <button id="editBtn" type="button" value="{{ $trainer->id }}"
                                                class="btn btn-primary btn-sm"><i class='fa fa-edit'></i></a></button>
                                            <a href="#" onclick="confirmDestroy({{ $trainer->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        <th>
                                            <a href="{{ route('trainer.attendanceReport', $trainer->id) }}"
                                                class="btn btn-sm btn-warning" style="color: #000">
                                                تقرير حضور وإنصراف
                                            </a>
                                            <a href="{{ route('trainer.financialreport', $trainer->id) }}"
                                                class="btn btn-sm btn-warning" style="color: #000">
                                                تقرير مالي
                                            </a>
                                        </th>
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


    <!-- Modal Add new Trainer -->
    <div class="modal fade" id="trainerid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                        اضافة مدرب جدبد
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('trainers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-6" style="padding: 10px">
                                <div class="form-group text-primary">
                                    <label for="name"> الأسم</label>
                                    <input type="text" class="form-control" id="name"
                                        aria-describedby="enameHelp" name="name" placeholder="أدخل الأسم">
                                    <small id="nameHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> الأسم ثلاثي @error('name')
                                            <p style="color: red ;  ">{{ $message }}</p>
                                        @enderror
                                    </small>
                                </div>

                                <div class="form-group text-primary">
                                    <label for="phone">الهاتف</label>
                                    <input type="tel" class="form-control" id="phone"
                                        aria-describedby="phoneHelp" placeholder="رقم الهاتف الشخصي " name="phone">
                                    <small id="phoneHelp" class="form-text text-muted">
                                        <span style="color: red;  font-weight: bolder">* </span> رقم الهاتف بدون المقدمة
                                        @error('phone')
                                            <p style="color: red ;">{{ $message }}</p>
                                        @enderror
                                    </small>
                                </div>
                                <div class="form-group text-primary">
                                    <label for="marital_status">الحالة الإجتماعية</label>
                                    <select name="marital_status" id="marital_status"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">
                                        <option value="" disabled selected hidden>إختار الحالة الإجتماعية</option>
                                        @foreach ($status as $st)
                                            <option value="{{ $st }}">{{ $st }}</option>
                                        @endforeach

                                    </select>
                                    @error('marital_status')
                                        <p style="color: red ;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary" style="width: 300px">
                                        <label for="image">صورة شخصية </label>
                                        <input class="form-control" type="file" id="image" name="image"
                                            style="height: 59px;">
                                    </div>
                                </div>
                                @error('image')
                                    <p style="color: red ">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-6" style="padding: 10px">
                                <div class="form-group text-primary">
                                    <label for="email">البريد الألكتروني</label>
                                    <input type="email" class="form-control" id="email"
                                        aria-describedby="emailHelp" placeholder="أدخل البريد الاكتروني" name="email">
                                    <small id="emailHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> لن نشارك بريدك الإلكتروني مع
                                        أي شخص
                                        آخر</small>
                                    @error('email')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group text-primary">
                                    <label for="age">العمر</label>
                                    <input type="number" max="40" min="19" class="form-control"
                                        id="age" aria-describedby="ageHelp" placeholder=" عمر المدرب"
                                        name="age">
                                    <small id="ageHelp" class="form-text text-muted">العمر </small>
                                    @error('age')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group text-primary">
                                    <label for="schedule"> شفت العمل والموعد</label>
                                    <select name="schedule" id="schedule"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">
                                        <option value="" disabled selected hidden> موعد العمل </option>
                                        @foreach ($schedules as $schedule)
                                            @php
                                                $temp_in = explode(':', $schedule->time_in);
                                                $hour_in = $temp_in[0]; // ساعات
                                                $minutes_in = $temp_in[1];
                                                
                                                $temp_out = explode(':', $schedule->time_out);
                                                $hour_out = $temp_out[0]; // ساعات
                                                $minutes_out = $temp_out[1];
                                            @endphp
                                            <option value="{{ $schedule->name }}">{{ $schedule->name }} ||
                                                {{ $hour_in }}:{{ $minutes_in }} ->
                                                {{ $hour_out }}:{{ $minutes_out }}

                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="phoneHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> الشفتات ومواعيد
                                        العمل</small>
                                    @error('schedule')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror

                                </div>


                            </div>
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

    {{-- Update Trainer Modal --}}
    <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                        تحديث معلومات المدرب
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/trainers/update') }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="trainerID" name="trainerID" />

                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-6" style="padding: 10px">
                                <div class="form-group text-primary">
                                    <label for="name"> الأسم</label>
                                    <input type="text" class="form-control" id="editname"
                                        aria-describedby="enameHelp" name="name" placeholder="أدخل الأسم">
                                    <small id="nameHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> الأسم ثلاثي @error('name')
                                            <p style="color: red ;  ">{{ $message }}</p>
                                        @enderror
                                    </small>
                                </div>

                                <div class="form-group text-primary">
                                    <label for="phone">الهاتف</label>
                                    <input type="tel" class="form-control" id="editphone"
                                        aria-describedby="phoneHelp" placeholder="رقم الهاتف الشخصي " name="phone">
                                    <small id="phoneHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> رقم الهاتف بدون المقدمة
                                        @error('phone')
                                            <p style="color: red ;">{{ $message }}</p>
                                        @enderror
                                    </small>
                                </div>
                                <div class="form-group text-primary">
                                    <label for="marital_status">الحالة الإجتماعية</label>
                                    <select name="marital_status" id="edit_marital_status"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">
                                        <option value="" disabled selected hidden>إختار الحالة الإجتماعية</option>
                                        @foreach ($status as $st)
                                            <option value="{{ $st }}">{{ $st }}</option>
                                        @endforeach

                                    </select>
                                    @error('marital_status')
                                        <p style="color: red ;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary" style="width: 300px">
                                        <label for="image">صورة شخصية </label>
                                        <input class="form-control" type="file" id="editimage" name="image"
                                            style="height: 59px;">
                                    </div>
                                </div>
                                @error('image')
                                    <p style="color: red ">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-6" style="padding: 10px">
                                <div class="form-group text-primary">
                                    <label for="email">البريد الألكتروني</label>
                                    <input type="email" class="form-control" id="editemail"
                                        aria-describedby="emailHelp" placeholder="أدخل البريد الاكتروني" name="email">
                                    <small id="emailHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> لن نشارك بريدك الإلكتروني مع
                                        أي شخص
                                        آخر</small>
                                    @error('email')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group text-primary">
                                    <label for="age">العمر</label>
                                    <input type="number" max="40" min="19" class="form-control"
                                        id="editage" aria-describedby="ageHelp" placeholder=" عمر المدرب"
                                        name="age">
                                    <small id="ageHelp" class="form-text text-muted">العمر </small>
                                    @error('age')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group text-primary">
                                    <label for="schedule"> شفت العمل والموعد</label>
                                    <select name="schedule" id="editschedule"
                                        class="form-select form-select-lg mb-3 text-primary form-control ">
                                        <option value="" disabled selected hidden> موعد العمل </option>
                                        @foreach ($schedules as $schedule)
                                            @php
                                                $temp_in = explode(':', $schedule->time_in);
                                                $hour_in = $temp_in[0]; // ساعات
                                                $minutes_in = $temp_in[1];
                                                
                                                $temp_out = explode(':', $schedule->time_out);
                                                $hour_out = $temp_out[0]; // ساعات
                                                $minutes_out = $temp_out[1];
                                            @endphp
                                            <option value="{{ $schedule->name }}">{{ $schedule->name }} ||
                                                {{ $hour_in }}:{{ $minutes_in }} ->
                                                {{ $hour_out }}:{{ $minutes_out }}

                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="phoneHelp" class="form-text text-muted"><span
                                            style="color: red;  font-weight: bolder">* </span> الشفتات ومواعيد
                                        العمل</small>
                                    @error('schedule')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror

                                </div>


                            </div>
                        </div>




                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

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

            axios.delete('/admin/trainers/' + id)
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
                var trainer_id = $(this).val();
                // alert(schedule_id);
                $('#editModel').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '/admin/trainers/' + trainer_id + '/edit',
                    success: function(response) {
                        console.log(response);
                        $('#editname').val(response.trainer.name);
                        $('#editphone').val(response.trainer.phone);
                        $('#editage').val(response.trainer.age);
                        $('#editemail').val(response.trainer.email);
                        $('#edit_marital_status').val(response.trainer.marital_status);
                        console.log(response.trainer.schedules);
                        var result = response.trainer.schedules.find(item => item.name);

                        $('#editschedule').val(result.name);
                        $('#trainerID').val(response.trainer.id);


                    }
                });
            });
        });
    </script>

    <script>
        /* When the user clicks on the button, 
                                                toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
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
    </script>
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
@endsection
