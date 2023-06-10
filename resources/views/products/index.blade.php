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
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">إدارة المنتجات</a></li>
                    <li class="breadcrumb-item active">قائمة المنتجات </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (Session()->has('statusDisCount'))
        @if (session('statusDisCount') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                تمت اضافة الخصم بنجاح
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية
            </div>
        @endif
    @endif


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

                                <a href="{{ route('products.create') }}" type="button" class="btn btn-primary">
                                    <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                    إضافة منتج جديد
                                </a>

                            </div>
                        </div>
                        <br>
                    </div>
                    <form action="{{ route('products.search') }}" method="GET">
                        <div style=" float: left; width: 800px">
                            <div class="main-header-center">
                                <input class="form-control"
                                    placeholder=" البحث عن طريق أسم المنتج أو أسم الفئة أو تاريخ الإنتهاء" type="search"
                                    name="search" id="search">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search d-none d-md-block"></i>
                                </button>

                            </div>
                        </div>
                    </form>


                </div>

                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table card-table  table-hover   mb-0 " style="text-align: center">
                            <thead>
                                <tr>
                                    <th>أسم المنتج</th>
                                    <th>الفئة</th>
                                    <th>سعر المنتج</th>
                                    <th>الكمية الموجودة</th>
                                    <th>نسبة الخصم </th>
                                    <th>السعر بعد الخصم </th>
                                    <th>تاريخ الإنتاج</th>
                                    <th>تاريخ الإنتهاء </th>
                                    <th>ملاحظات حول المنتج</th>
                                    <th>صورة</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($products))
                                    @foreach ($products as $product)
                                        <tr>

                                            <td class="text-nowrap">{{ $product->name }}</td>
                                            <th class="text-nowrap">
                                                <span class="badge rounded-pill bg-warning text-dark">
                                                    {{ $product->category->name }}</span>


                                            </th>
                                            <td class="text-nowrap">{{ $product->base_price }}<span style="color: red">
                                                    ₪.</span></td>
                                            <td class="text-nowrap">{{ $product->quantity }}</td>
                                            <td class="text-nowrap">
                                                <a  class="btn btn-info btn-sm " href="{{ route('product.createDiscount', $product->id) }}">

                                                    %{{ $product->discount }}
                                                </a>

                                            </td>
                                            <td>{{ $product->price_after_discount ?? null }} <span style="color: red">
                                                ₪.</span></td>
                                            <td class="text-nowrap">{{ $product->production_date ?? null }}</td>
                                            <td class="text-nowrap">{{ $product->expiry_date ?? null }}</td>
                                            <td style="overflow:hidden;">
                                                @if ($product->description == null)
                                                    -----------------
                                                @else
                                                    {{ $product->description ?? null }}
                                            </td>
                                    @endif

                                    <td>
                                        <img src="{{ $product->image }}" alt="image" width="30spx" height="30px">

                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary btn-sm edit btn-flat">
                                            <i class='fa fa-edit'></i></a>
                                        <a href="#" onclick="confirmDestroy({{ $product->id }} , this)"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                    </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>

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
            axios.delete('/admin/products/destroy/' + id)
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
