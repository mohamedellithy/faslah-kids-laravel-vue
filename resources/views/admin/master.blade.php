@extends('layouts.app')
@section('styles')
  <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- Bootstrap CSS -->

@endsection
@section('content')

    <router-view></router-view>
    <!-- set progressbar -->
    <vue-progress-bar></vue-progress-bar>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/custom/css/style.css') }}" defer/>
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
