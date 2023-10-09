@extends('layouts.master_front')

@section('content')
<section class="container register page-bg">
    <div class="row">
        <div class="d-flex login-form">
            <div class="form-login">
                <div class="heading">
                    <h4>اعادة ضبط كلمة المرور</h4>
                    <p class="description">
                        يمكنك التسجيل الدخول فى منصتنا و الاستفدة بخدماتنا و منتجاتنا الرقمية
                    </p>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">البريد الالكترونى</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="email"/>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        ارسال رابط اعادة ضبط كلمة المرور
                    </button>
                </form>
            </div>
            <div class="banner-register">
                <div class="left-banner">
                    <img src="{{ asset('front/assets/img/images/h3_testimonial_img.jpg') }}" class="" />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


