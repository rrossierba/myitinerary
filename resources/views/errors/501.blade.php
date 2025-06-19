@extends('layouts.error')

@section('title')
@lang('errors.not_implemented')
@endsection

@section('error_title')
@lang('errors.not_implemented')
@endsection

@section('image')
<img src="{{ url('/') }}/img/coming-soon.png" style="width:75%">
@endsection

@section('error_general_message')
@lang('errors.501_general_message')
@endsection

@section('error_footer')
<a class="btn btn-outline-secondary" href="{{ url()->previous() }}"><i class="bi bi-box-arrow-left"></i> @lang('errors.come_back')</a>
@endsection

