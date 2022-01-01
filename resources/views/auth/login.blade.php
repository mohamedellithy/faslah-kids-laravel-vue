@extends('layouts.app')
@section('styles')
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
                        <form method="POST" action="{{ url('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-12 col-form-label text-md-right">{{ __(' بريدك الالكترونى ؟') }}</label>

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
                                <label for="password" class="col-12 col-form-label text-md-right">{{ __('الكلمة السرية لحسابك') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="forget-password">
                                <a class="btn btn-link" href="{{ route('register',['barcode'=>123]) }}">
                                    {{ __('نسيت الكلمة السرية ؟') }}
                                </a>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('سجل دخول') }}
                                    </button>
                                </div>
                            </div>

                            <a class="btn btn-link" href="{{ route('register',['barcode'=>123]) }}">
                                {{ __('هل لا تمتلك حساب ؟يمكنك انشاء حساب جديد ') }}
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

@endsection
