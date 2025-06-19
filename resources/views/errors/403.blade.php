@extends('layouts.error')

@section('title')
403 - @lang('errors.access_denied')
@endsection

@section('error_title')
@lang('errors.access_denied')
@endsection

@section('error_general_message')
@lang('errors.403_general_message')
@endsection