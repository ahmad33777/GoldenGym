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
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">إدارة المنتجات </a></li>
                    <li class="breadcrumb-item active">قائمة الفئات </li>
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
                تمت اضافة الفئة الجديدة بنجاح
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت اضافة الفئة
            </div>
        @endif
    @endif
    @if (Session()->has('updateStatus'))
        @if (session('updateStatus') == true)
            <div class="alert fw-bold" role="alert" style="background-color: #14628c; color: white ; border-radius:15px;">
                عملية تحديث معلومات الفئة تمت بنجاح
            </div>
        @else
            <div class="alert fw-bold" role="alert" style="background-color: #da1313; color: white ; border-radius:15px;">
                فشلت عملية تحديث معلومات الفئة يرجى المحاولة مرة أخرى
            </div>
        @endif
    @endif

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row" style="display: flex;  justify-content: space-between">
                        <form action="{{ route('categories.search') }}" method="post">
                            @csrf
                            <div style="width: 500px">
                                <div class="main-header-center">
                                    <input class="form-control" placeholder="ادخل من اجل البحث" type="search"
                                        name="search" id="search">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search d-none d-md-block"></i>
                                    </button>

                                </div>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-12 margin-tb">
                                <div>

                                    <a href="{{ route('categories.create') }}" type="button" class="btn btn-primary">
                                        <i class="fas fa-plus-square">&nbsp;&nbsp;</i>
                                        فئة جديدة
                                    </a>

                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  table-hover" style="text-align: center">
                            <thead style="font-size: 25px">
                                <tr>
                                    <th style="text-align: right">الفئة</th>
                                    <th>عدد المنتجات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($categores))
                                    @foreach ($categores as $category)
                                        <tr>
                                            <td style="text-align: right">{{ $category->name }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $category->products_count }}
                                                </span>

                                            </td>

                                            <td>
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-primary   edit ">
                                                    تعديل
                                                </a>
                                                <a href="#" onclick="confirmDestroy({{ $category->id }}, this)"
                                                    class="btn btn-danger  ">
                                                    حذف
                                                </a>
                                                <a
                                                    href="{{ route('categories.productReport', $category->id) }}"class="btn btn-warning">
                                                    تقرير المنتجات</i>
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
            axios.delete('/admin/categories/destroy/' + id)
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
