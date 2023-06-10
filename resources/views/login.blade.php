@extends('layouts.master2')
@section('title')
    تسجيل دخول - برنامج الفواتير
@stop

@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5" style="background-color: #1E85F1 ;">
                <div class="login
                d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5" style="text-align: center">

                                        <img src="{{ URL::asset('assets/image/logo2.png') }}" alt="logo">
                                        <br>

                                        &nbsp;&nbsp;&nbsp;
                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-40"
                                            style="color: #FFD700; font-weight:900   ">
                                            Golden <span style="color: #fff">Gym</span>
                                        </h1>
                                    </div>
                                    @if (\Session::has('error'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                <li>{!! \Session::get('error') !!}</li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2 style="color: #fff">مرحبا بك</h2>
                                            <h5 style="color: #fff" class="font-weight-semibold mb-4"> تسجيل الدخول</h5>

                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label style="color: #fff">البريد الالكتروني</label>
                                                    <input id="email" name="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                                        placeholder="example@gmail.com">

                                                </div>

                                                <div class="form-group">
                                                    <label style="color: #fff">كلمة المرور</label>

                                                    <input name="password" placeholder="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        required autocomplete="current-password"
                                                        placeholder="..............">

                                                    <div class="form-group row">
                                                        <div class="col-md-6 offset-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="remember" name="remember"
                                                                    {{ old('remember') ? 'checked' : '' }}>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <label style="color: #fff" class="form-check-label"
                                                                    for="remember">
                                                                    {{ __('تذكرني') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit"class="btn  btn-block"
                                                    style="background-color: #FFD700">
                                                    {{ __('تسجيل الدخول') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div>
            <!-- End  form login-->

            <!-- start  imag  section-->

            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/image/logobackground.png') }}" class="my-auto" alt="logo">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@endsection
