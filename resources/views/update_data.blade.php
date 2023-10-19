@extends('welcome')
@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@endsection
@section('script')
@endsection