@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subscribers.index') }}">قائمة المشتركين</a></li>
                    <li class="breadcrumb-item active">إدارة المشتركين </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('status'))
        @if (session('status') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                نجحت العمليةالأضافة
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية
            </div>
        @endif
    @endif
    @if (Session()->has('updateStatus'))
        @if (session('updateStatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                نجحت عملية التحديث
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية التحديث
            </div>
        @endif
    @endif
    @if (Session()->has('incomingstatus'))
        @if (session('incomingstatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #fd7e14; color: white ; border-radius:15px;">
                تمت إضافة الدفعة المالية بنجاح
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية إضافة الدفعة المالية
            </div>
        @endif
    @endif

    @if (Session()->has('subscription_renewal'))
        @if (session('subscription_renewal') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #fbbc0b ; color: #000 ; border-radius:15px;">
                تم تجديد الإشتراك بنجاح
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية تجديد الإشتراك
            </div>
        @endif
    @endif
    @if ($errors->any())
        <div class="alert  fw-bold" style="background-color: #da1313; color: white ; border-radius:15px " role="alert">
            فشلت العملية هناك خطأ في البيانات المدخلة من فضلك حاول مرة أخرى
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">

                                <a href="{{ route('subscribers.create') }}" type="button" class="btn btn-primary">
                                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    اضافة مشترك جديد
                                </a>

                            </div>
                        </div>
                        <br>
                    </div>
                    <form action="{{ route('subscribers.search') }}" method="GET">
                        <div style=" float: left; width: 800px">
                            <div class="main-header-center">
                                <input class="form-control" placeholder=" الاسم    -    الهاتف   " type="search"
                                    name="search" id="search">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search d-none d-md-block"></i>
                                </button>

                            </div>
                        </div>
                    </form>


                </div>

                <div class="card-body">
                    <div class="table-responsive  ">
                        <table class="table card-table  table-hover  text-nowrap mb-0 " style="text-align: center">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>الإسم</th>
                                    <td> الهاتف</td>
                                    <th style="color: blue; font-weight: bold">نوع الإشتراك</td>
                                    <td style="color: blue; font-weight: bold">بداية الإشتراك</td>
                                    <td style="color: blue; font-weight: bold">نهاية الإشتراك</td>
                                    <td>المدرب</td>
                                    <td>المديونية</td>
                                    <td>الحالة</td>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                    <tr>
                                        <td>
                                            <div class="dropdownSub">
                                                <button onclick="showD()" class="dropbtn">::</button>
                                                <div id="myDropdown" class="dropdown-content">
                                                    <a
                                                        href="{{ route('subscriber.searchFinancialReport', $subscriber->id) }}">تقرير
                                                        مالي</a>
                                                    <a
                                                        href="{{ route('subscriber.showSubscriptionReport', $subscriber->id) }}">
                                                        تقرير الإشتراك</a>
                                                    @if ($subscriber->status == 1)
                                                        <a
                                                            href="{{ route('subscriber.statusChangeInactive', $subscriber->id) }}">تعطيل
                                                            المشترك</a>
                                                    @else
                                                        <a
                                                            href="{{ route('subscriber.changeStatusActive', $subscriber->id) }}">تفعيل
                                                            المشترك</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $subscriber->name }}</td>
                                        <td>{{ $subscriber->phone }}</td>
                                        <td style="color: blue;  font-weight: bold">
                                            {{ $subscriber->subscription->subscription_type }}</td>
                                        <td style="color: blue; font-weight: bold ">{{ $subscriber->subscription_start }}
                                        </td>
                                        <td style="color: blue; font-weight: bold">{{ $subscriber->subscription_end }}</td>
                                        <td>{{ $subscriber->trainer->name }}</td>
                                        <td>
                                            @if (isset($subscriber->indebtedness) == null)
                                                0 <b style="color: red">₪.</b>
                                            @else
                                                {{ $subscriber->indebtedness ?? null }} <b style="color: red">₪.</b>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($subscriber->status == 1)
                                                <span class="badge bg-success text-white">فعال</span>
                                            @else
                                                <span class="badge bg-danger ">غير فعال</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('subscribers.edit', $subscriber->id) }}"
                                                class="btn btn-primary btn-sm edit btn-flat">
                                                <i class='fa fa-edit'></i></a>
                                            <a href="#" onclick="confirmDestroy({{ $subscriber->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            </a>




                                            <a href="{{ route('subscribers.subscriptionRenewal', $subscriber->id) }}"
                                                class="btn btn-warning text-dark btn-sm" style="font-size: 12px; ">تجديد
                                                إشتراك</a>


                                            <button id="financial_boost_btn" type="button" value="{{ $subscriber->id }}"
                                                class="btn btn-primary  btn-sm"
                                                style="font-size: 12px; background-color:#fd7e14 ; color: #fff">
                                                <i class="fas fa-sharp fa-solid fa-dollar-sign"></i></a></button>

                                            </button>
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


    {{-- add دفعة مالية  --}}
    <div class="modal fade mt-2" id="add_financial_boost" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" style="">
        <div class="modal-dialog" role="document" style="top: 50% ; transform: translateY(-50%) ">
            <div class="modal-content">
                <div class="modal-header bg-warning" style="background-color: ">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                        إضافة دفعة مالية للمشترك <input id="subName" disabled width="100px"
                            style="border-radius:10px; border:transparent ; background-color: transparent ; text-align: center">

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/subscribers/addFinancialBoost') }}" method="POST">

                    <input type="hidden" id="subID" name="subID" />
                    @csrf
                    <div class="modal-body ">
                        <p id="subName"> </p>
                        <div class="form-group text-primary">
                            <p>قيمة الدفعة المالية</p>
                            <input type="number" class="form-control" placeholder="قيمة الدفعة المالية"
                                style="border-radius:10px;" name="financial_boost" id="financial_boost"
                                value="{{ old('financial_boost') }}">
                            <small id="nameHelp" class="form-text text-muted">
                                @error('financial_boost')
                                    <p style="color: red ; font-weight: bold">{{ $message }}</p>
                                @enderror
                            </small>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" style="border-radius:10px "
                            data-dismiss="modal">إغلاق</button>
                        {{-- <button type="submit" class="btn btn-primary">اضافة</button> --}}
                        <button type="submit" style="border-radius:10px" class="btn btn-warning"> &nbsp; تصدير
                            &nbsp; <i class="fas fa-sharp fa-solid fa-dollar-sign"></i></button>
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
            axios.delete('/admin/subscribers/destroy/' + id)
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
            $(document).on('click', '#financial_boost_btn', function() {
                var subscriberID = $(this).val();
                $('#add_financial_boost').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '/admin/subscribers/financialBoost/' + subscriberID,
                    success: function(response) {
                        // console.log(response);
                        $('#subName').val(response.subscriber.name);
                        $('#subID').val(response.subscriber.id);


                    }
                });
            });
        });
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
