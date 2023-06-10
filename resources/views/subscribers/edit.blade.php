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
                    <li class="breadcrumb-item active">الملف الشخصي</li>

                    <li class="breadcrumb-item active"> تعديل الملف الشخصي </li>
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
                        <h3 class="card-title">تعديل معلومات المشترك </h3>
                    </div>
                   
                    
                    <form action="{{ route('subscribers.update', $subscriber->id) }}" method="POST" id="create_form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                            style=" border: 1px solid #1196db"
                                            value="{{ $subscriber->name }}">
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
                                            style="border: 1px solid #1196db ; text-align: right"
                                            value="{{ $subscriber->phone }}">
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
                                            style=" color: black; ">
                                            <option value="" disabled selected hidden>الحالة الإجتماعية</option>
                                            <option value="أعزب" @if ($subscriber->marital_status == 'أعزب') selected @endif>أعزب
                                            </option>
                                            <option value="متزوج" @if ($subscriber->marital_status == 'متزوج') selected @endif>متزوج
                                            </option>
                                            <option value="مطلق" @if ($subscriber->marital_status == 'مطلق') selected @endif>مطلق
                                            </option>
                                            <option value="أرمل" @if ($subscriber->marital_status == 'أرمل') selected @endif>أرمل
                                            </option>
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
                                            id="age"   value="{{ $subscriber->age }}">
                                    </div>
                                    @error('age')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="weight" style="font-weight: 900">الوزن</label>
                                        <input type="number" class="form-control" placeholder=" الوزن" name="weight"
                                            id="weight"  value="{{ $subscriber->weight }}">
                                    </div>
                                    @error('weight')
                                        <p style="color: red ">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group text-primary">
                                        <label for="height" style="font-weight: 900">الطول</label>
                                        <input type="number" class="form-control" placeholder=" الطول" name="height"
                                            id="height"   value="{{ $subscriber->height }}">
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
                                            id="health_status" 
                                            value="{{ $subscriber->health_status }}">
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
                                                name="subscription_start" value="{{ $subscriber->subscription_start }}"
                                                style="  border: 1px solid #1196db">
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
                                                name="subscription_end" value="{{ $subscriber->subscription_end }}"
                                                style="  border: 1px solid #1196db">
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
                                            style="  border: 1px solid #1196db"">
                                            <option value="" disabled selected hidden> نوع الإشتراك</option>
                                            @foreach ($subscriptions as $subscription)
                                                <option value="{{ $subscription->id }}"
                                                    @if ($subscription->id == $subscriber->subscription_id) selected @endif>
                                                    {{ $subscription->subscription_type }}</option>
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
                                            style="  border: 1px solid #1196db">
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
                                </div>
                            </div>
                            <br>


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
    <br>
    <br>
    <br>
    <br>

@endsection
