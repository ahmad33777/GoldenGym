@extends('layouts.master')

@section('title')
    Golden Gym
@stop

@section('page-header')
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item active">إدارة الشكاوي </li>
                    <li class="breadcrumb-item active">أرشيف الشكاوي </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " style="text-align: center">
                            <thead>
                                <tr>
                                    <th>أسم المشترك</th>
                                    <th> رقم الهاتف</th>
                                    <th>تاريخ الشكوى</th>
                                    <th>رسالة الشكوى</th>
                                    <th>نوع الشكوى</th>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                @if (isset($complaints))
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $complaint->subscriber->name }}</td>
                                            <td>{{ $complaint->subscriber->phone }}</td>
                                            <td>{{ $complaint->complaint_Date }}</td>
                                            <td>{{ $complaint->complaint }}</td>
                                            <td>{{ $complaint->complaint_type }}</td>
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


    {!! $complaints->withQueryString()->links('pagination::bootstrap-5') !!}

 

@endsection

@section('js')

@endsection
