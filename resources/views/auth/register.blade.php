@extends('layouts.app')
@section('styles')
 <link rel="stylesheet" href="{{ asset('assets/custom/plugins/jquery-nice-select/css/nice-select.css') }}"/>
 <link rel="stylesheet" href="{{ asset('assets/custom/css/front.css') }}"/>
 <script type="text/javascript" src="{{ asset('assets/custom/js/jquery.js') }}"></script>

@endsection
@section('content')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <img src="{{ asset('images/fa-9-lahlogo@3x.png') }}" />
                        <h2> {{ __('مرحبا بك فى فاصلة') }} </h2>
                        <p> {{ __('هيا بنا نسجل حساب جديد') }} </p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register',['barcode'=>'123']) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">{{ __('ما هو اسمك ؟') }}</label>

                                <div class="col-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">{{ __('ما هو اسم عائلتك ؟') }}</label>

                                <div class="col-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                             <div class="form-group row">
                                <label for="name" class="col-12 col-form-label text-md-right">{{ __('كم عمرك ؟') }}</label>

                                <div class="col-12">
                                    <select id="select-age" class="wide @error('name') is-invalid @enderror" name="age" required autocomplete="name" autofocus>
                                        @for($age = 3 ; $age<20; $age++)
                                           <option value="{{ $age }}">{{ $age }}</option>
                                        @endfor
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-12 col-form-label text-md-right">{{ __('ما هو بريدك الالكترونى ؟') }}</label>

                                <div class="col-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-12 col-form-label text-md-right">{{ __('اختر كلمة سرية لحسابك ') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-12 col-form-label text-md-right">{{ __('قم بتأكيد الكلمة السرية التى قمت باختيارها') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('سجل حساب جديد') }}
                                    </button>
                                </div>
                            </div>

                            <a class="btn btn-link" href="{{ route('login',['barcode'=>123]) }}">
                                {{ __('هل بالفعل تمتلك حساب ؟ يمكنك تسجيل الدخول ') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')


    <script type="text/javascript" src="{{ asset('assets/custom/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/custom/plugins/jquery-nice-select/js/fastclick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/custom/plugins/jquery-nice-select/js/prism.js') }}"></script>
 <script type="text/javascript">
    $(document).ready(function() {
       $('select').niceSelect();
    });
 </script>
@endsection
