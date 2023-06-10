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
                    <li class="breadcrumb-item active"> اضافة مشترك</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')


    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">إضافة مشترك جديد</h3>
                    </div>
                    <form action="{{ route('subscribers.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <b>المعلومات الشخصية للمشترك</b>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="name" style="font-weight: 900">أسم
                                            المشترك</label>
                                        <input type="test" class="form-control" placeholder="أدخل أسم المشترك"
                                            name="name" id="name"
                                            style="border-radius:10px ;border: 1px solid #1196db" value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="phone" style="font-weight: 900">رقم
                                            الهاتف</label>
                                        <input type="tel" class="form-control" placeholder="أدخل رقم الهاتف"
                                            name="phone" id="phone"
                                            style="border-radius:10px ; border: 1px solid #1196db" value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="marital_status" style="font-weight: 900">الحالة الإجتماعية</label>
                                        <select name="marital_status" id="marital_status"
                                            class="form-select form-select-lg mb-3   form-control "
                                            style="border-radius:10px; color: black; ">
                                            <option value="" disabled selected hidden>الحالة الإجتماعية</option>
                                            <option value="أعزب" >أعزب</option>
                                            <option value="متزوج">متزوج</option>
                                            <option value="مطلق">مطلق</option>
                                            <option value="أرمل">أرمل</option>
                                        </select>

                                        @error('marital_status')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-4">

                                    <div class="form-group text-primary">
                                        <label for="age" style="font-weight: 900">العمر</label>
                                        <input type="number" class="form-control" placeholder=" العمر" name="age"
                                            id="age" style="border-radius:10px;" value="{{ old('age') }}">
                                    </div>
                                    @error('age')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="weight" style="font-weight: 900">الوزن</label>
                                        <input type="number" class="form-control" placeholder=" الوزن" name="weight"
                                            id="weight" style="border-radius:10px ;" value="{{ old('weight') }}">
                                    </div>
                                    @error('weight')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="height" style="font-weight: 900">الطول</label>
                                        <input type="number" class="form-control" placeholder=" الطول" name="height"
                                            id="height" style="border-radius:10px;" value="{{ old('height') }}">
                                    </div>
                                    @error('height')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="health_status" style="font-weight: 900">الحالة الصحية</label>
                                        <input type="text" class="form-control"
                                            placeholder="هل يعاني من مرض (سكر - ضغط أوغيره )" name="health_status"
                                            id="health_status" style="border-radius:10px;" value="{{ old('health_status') }}">
                                    </div>
                                    @error('health_status')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <p><b>معلومات الإشتراك</b></p>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_start"
                                            style="font-weight: 900"> تاريخ
                                            بداية الإشتراك </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="subscription_start"
                                                name="subscription_start" value=""
                                                style="border-radius:10px ; border: 1px solid #1196db">
                                        </div>
                                        @error('subscription_start')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_end"
                                            style="font-weight: 900">تاريخ
                                            نهاية الإشتراك </label>
                                        <div class="bootstrap-datepicker">
                                            <input type="date" class="form-control timepicker" id="subscription_end"
                                                name="subscription_end" value=""
                                                style="border-radius:10px ; border: 1px solid #1196db">
                                        </div>
                                        @error('subscription_end')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>



                            </div>
                            <div class="row">
                                <div class="col-4 ">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="subscription_id"
                                            style="font-weight: 900">نوع
                                            الإشتراك</label>
                                        <select name="subscription_id" id="subscription_id"
                                            class="form-select form-select-lg mb-4 form-control "
                                            style="border-radius:10px; border: 1px solid #1196db"">
                                            <option value="" disabled selected hidden> نوع الإشتراك</option>
                                            @foreach ($subscriptions as $subscription)
                                            <option value="{{ $subscription->id }}" @if($subscription->id == old('subscription_id')) selected @endif>{{ $subscription->subscription_type }}</option>

                                            @endforeach
                                         </select>
                                        @error('subscription_id')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="col-4 ">
                                    <div class="form-group text-primary">
                                        <b style="color: red">*</b> <label for="trainer_id" style="font-weight: 900">
                                            المدرب</label>
                                        <select name="trainer_id" id="trainer_id"
                                            class="form-select form-select-lg mb-4 form-control "
                                            style="border-radius:10px; border: 1px solid #1196db">
                                            <option value="" disabled selected hidden>أسم المدرب</option>
                                            @foreach ($trainers as $trainer)
                                            <option value="{{ $trainer->id }}" @if($trainer->id == old('trainer_id')) selected @endif>{{ $trainer->name }}</option>
                                             @endforeach
                                             
                                        </select>
                                        @error('trainer_id')
                                            <p style="color: red ">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <br>
                            <p><b> <i class="fas fa-money-check-alt"></i> معلومات مالية</b></p>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="first_batch" style="font-weight: 900">دفعة مالية أولى</label>
                                        <input type="number" class="form-control" placeholder="الدفعة المالية الأولى "
                                            style="border-radius:10px; " name="first_batch" id="first_batch" value="{{ old('first_batch') }}">
                                    </div>
                                    @error('first_batch')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" style="border-radius:10px " class="btn btn-primary"
                                name="submit">حفظ</button>



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
