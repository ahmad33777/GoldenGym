@extends('layouts.master')

@section('title')
    Golden Gym
@stop
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصفحة الرئيسية</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    إدارة الإشتراكات </span>
            </div>
        </div>
    </div>
    <hr>
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
                فشلت العمليةالأضافة
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
    @if ($errors->any())
        <div class="alert  fw-bold" style="background-color: #da1313; color: white ; border-radius:15px " role="alert">
            فشلت العملية هناك خطأ في البيانات المدخلة من فضلك حاول مرة أخرى
        </div>
    @endif

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-header pb-0">
                    <form action="{{ route('subscriptions.search') }}" method="GET">
                        <div style=" float: left;">
                            <div class="main-header-center">
                                <input class="form-control"
                                    placeholder="أدخل  الإسم . عدد التمارين أ, السعر  من أجل البحث عم إشتراك معين  ؟"
                                    type="search" name="search" id="search" style="width: 500px">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search d-none d-md-block"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addNewSubscription">
                                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    إشتراك جديد
                                </button>

                            </div>
                        </div>
                        <br>
                    </div>



                </div>
                <br>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover ">
                            <thead>
                                <tr>
                                    <td>نوع الإشتراك</td>
                                    <td>عدد أيام التمرين</td>
                                    <td>سعر الاشتراك</td>
                                    <td>العمليات</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->subscription_type }}</td>
                                        <td>{{ $subscription->number_exercises }}</td>
                                        <td>{{ $subscription->subscription_price }} &nbsp;<span style="color: red">₪.</span>
                                        </td>
                                        <td>
                                            <button id="editBtn" type="button" value="{{ $subscription->id }}"
                                                class="btn btn-primary btn-sm edit btn-flat editbtn"><i
                                                    class='fa fa-edit'></i></a></button>
                                            <a href="#" onclick="confirmDestroy({{ $subscription->id }}, this)"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                            </a>
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


    <!--start  Add  module-->
    <div class="modal fade" id="addNewSubscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        <i class="fa fa-dumbbell"></i>
                        إشتراك جديد
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- form to add subscriptions  --}}
                <form action="{{ route('subscriptions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group text-primary">
                            <label for="subscription_type">نوع الإشتراك</label>
                            <input type="text" class="form-control" id="subscription_type" aria-describedby="nameHelp"
                                name="subscription_type" placeholder="   نوع الأشتراك   (عبارة عن أسم يدل على الإشتراك)">
                        </div>
                        <small id="nameHelp" class="form-text text-muted">
                            @error('subscription_type')
                                <p style="color: red ;  ">{{ $message }}</p>
                            @enderror
                        </small>
                        <div class="form-group text-primary">
                            <label for="number_exercises">عدد إيام التدريب</label>
                            <input type="number" min="1" class="form-control" id="number_exercises"
                                aria-describedby="nameHelp" name="number_exercises"
                                placeholder="عدد  التمارين في هذا الإشتراك   ">
                        </div>
                        @error('number_exercises')
                            <p style="color: red ;  ">{{ $message }}</p>
                        @enderror
                        <div class="form-group text-primary">
                            <label for="subscription_price">سعر الإشتراك</label>
                            <input type="number" min="30" class="form-control" id="subscription_price"
                                aria-describedby="nameHelp" name="subscription_price" placeholder="ثمن هذا الإشتراك    ">
                        </div>
                        @error('subscription_price')
                            <p style="color: red ;  ">{{ $message }}</p>
                        @enderror



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end Add module -->

    <!-- start Edit module -->
    <div class="modal fade" id="editNewSubscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        <i class="fa fa-dumbbell"></i>
                        تحديث معلومات الإشتراك
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- form to  update  subscriptions  --}}
                <form action="{{ url('admin/subscriptions/update') }}" method="POST">
                    <input type="hidden" id="subscriptionID" name="subscriptionID" />
                    @method('PUT')
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group text-primary">
                            <label for="subscription_type">نوع الإشتراك</label>
                            <input type="text" class="form-control" id="edit_subscription_type"
                                aria-describedby="nameHelp" name="edit_subscription_type"
                                placeholder="   نوع الأشتراك   (عبارة عن أسم يدل على الإشتراك)">
                        </div>
                        <small id="nameHelp" class="form-text text-muted">
                            @error('edit_subscription_type')
                                <p style="color: red ;  ">{{ $message }}</p>
                            @enderror
                        </small>
                        <div class="form-group text-primary">
                            <label for="number_exercises">عدد إيام التدريب</label>
                            <input type="number" min="1" class="form-control" id="edit_number_exercises"
                                aria-describedby="nameHelp" name="edit_number_exercises"
                                placeholder="عدد  التمارين في هذا الإشتراك   ">
                        </div>
                        @error('edit_number_exercises')
                            <p style="color: red ;  ">{{ $message }}</p>
                        @enderror
                        <div class="form-group text-primary">
                            <label for="subscription_price">سعر الإشتراك</label>
                            <input type="number" min="30" class="form-control" id="edit_subscription_price"
                                aria-describedby="nameHelp" name="edit_subscription_price"
                                placeholder="ثمن هذا الإشتراك    ">
                        </div>
                        @error('edit_subscription_price')
                            <p style="color: red ;  ">{{ $message }}</p>
                        @enderror



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">اضافة</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- EndEdit module -->



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
            axios.delete('/admin/subscriptions/destroy/' + id)
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
                var subscription_id = $(this).val();
                // alert(subscription_id);
                $('#editNewSubscription').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '/admin/subscriptions/edit/' + subscription_id,
                    success: function(response) {
                        $('#edit_subscription_type').val(response.subscription
                            .subscription_type);
                        $('#edit_number_exercises').val(response.subscription.number_exercises);
                        $('#edit_subscription_price').val(response.subscription
                            .subscription_price);
                        $('#subscriptionID').val(response.subscription.id);
                    }
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@endsection
