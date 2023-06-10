@extends('layouts.master')
@section('title')
    Golden Gym
@stop
@section('page-header')
    <!-- breadcrumb -->
    <!-- breadcrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="rounded-3  m-2 ">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subscribers.index') }}">قائمة المشتركين</a></li>
                    <li class="breadcrumb-item active"> تجديد الإشتراك </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header" style="display: flex ; justify-content: space-between;">
                        <h3 class="card-title"> تجديد الإشتراك
                            / حالة الإشتراك
                            @if ($subscriber->status == 1)
                                <span class="badge badge-success">فعال</span>
                            @else
                                <span class="badge badge-danger">غير فعال</span>
                            @endif
                        </h3>
                        <h2 style="background-color: #fbbc0b ; padding: 5px ; border-radius:8px "> المديونية <span
                                style="color: red">{{ $subscriber->indebtedness }}</span> ₪.</h2>
                    </div>
                    <form action="{{ route('subscriptionRenewal.update', $subscriber->id) }}" method="POST"
                        id="create_form">
                        @csrf
                        <div class="card-body" style="">

                            <div class="row">
                                <div class="col-5 ml-5">

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="name" style="font-weight: 900">أسم
                                            المشترك</label>
                                        <input type="test" class="form-control" placeholder="أدخل أسم المشترك"
                                            name="name" id="name"
                                            style="border-radius:10px ;border: 1px solid #1196db"
                                            value="{{ $subscriber->name }}">
                                    </div>
                                    @error('name')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="trainer_id" style="font-weight: 900">
                                            أسم المدرب</label>
                                        <select name="trainer_id" id="trainer_id"
                                            class="form-select form-select-lg mb-4 form-control "
                                            style="border-radius:10px; border: 1px solid #1196db">
                                            <option value="" disabled selected hidden>أسم المدرب</option>
                                            @foreach ($trainers as $trainer)
                                                <option value="{{ $trainer->id }}"
                                                    @if ($trainer->id == $subscriber->trainer_id) selected @endif>{{ $trainer->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('trainer_id')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="financial_boost"
                                            style="font-weight: 900">دفعة
                                            مالية جديد</label>
                                        <input type="number" class="form-control" placeholder="دفعة مالية جديد"
                                            style="border-radius:10px; border: 1px solid #1196db" name="financial_boost"
                                            id="financial_boost" value="{{ old('financial_boost') }}">
                                    </div>
                                    @error('financial_boost')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-5">

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_start"
                                            style="font-weight: 900"> تاريخ
                                            بداية الإشتراك </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="subscription_start"
                                                name="subscription_start"
                                                style="border-radius:10px ; border: 1px solid #1196db">
                                        </div>
                                        @error('subscription_start')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_end"
                                            style="font-weight: 900">تاريخ
                                            نهاية الإشتراك </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="subscription_end"
                                                name="subscription_end"
                                                style="border-radius:10px ; border: 1px solid #1196db">
                                        </div>
                                        @error('subscription_end')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_id"
                                            style="font-weight: 900">نوع
                                            الإشتراك</label>
                                        <select name="subscription_id" id="subscription_id"
                                            class="form-select form-select-lg mb-4 form-control "
                                            style="border-radius:10px; border: 1px solid #1196db">
                                            <option value="" disabled selected hidden> نوع الإشتراك</option>
                                            @foreach ($subscriptions as $subscription)
                                                <option value="{{ $subscription->id }}">
                                                    {{ $subscription->subscription_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('subscription_id')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" style="border-radius:10px; " class="btn btn-warning"><i
                                    class="fas fa-check"></i> &nbsp; حفظ&nbsp;</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>

@endsection
