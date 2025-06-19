@extends('layouts.error')

@section('title')
405 - @lang('errors.method_not_allowed')
@endsection

@section('error_title')
@lang('errors.method_not_allowed')
@endsection

@section('error_general_message')
@lang('errors.405_general_message')
@endsection