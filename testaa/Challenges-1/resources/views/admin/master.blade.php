@extends('layouts.app')
@section('styles')
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

@endsection
@section('content')

    <router-view></router-view>
    <!-- set progressbar -->
    <vue-progress-bar></vue-progress-bar>
@endsection

@section('scripts')
    @if(Auth::check())
        <script type="text/javascript">
                window.Authentication  = {!! json_encode([
                    'isLoggedin' => true,
                    'userInfo'   => Auth::user(),
                    'admin'      => Auth::user()->isAdmin()
                ]) !!}
        <script>
    @else
        <script type="text/javascript">
                window.Authentication  = {!! json_encode([
                    'isLoggedin' => false
                ]) !!}
        </script>
    @endif
   <link rel="stylesheet" href="{{ asset('assets/custom/css/style.css') }}" defer/>
@endsection
