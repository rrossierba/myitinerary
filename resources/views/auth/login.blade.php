@extends('layouts.master')

@section('title', 'Login')

@section('scripts')
    <script>
        $(document).ready(function () {
            $('form[name=login]').submit(function (event) {
                event.preventDefault();

                $('#wrongCredentials').hide();

                let error = false;

                if ($('input[name=email]').val() === '') {
                    error = true;
                    $('#errorEmail').removeClass('d-none').text('@lang('passwords.error_missing_email')');
                    $('input[name=email]').addClass('is-invalid').focus();
                }else if (!$('input[name=email]').val().match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
                    error = true;
                    $('#errorEmail').removeClass('d-none').text('@lang('passwords.error_format_email')');
                    $('input[name=email]').addClass('is-invalid').focus();
                }else{
                    $('#errorEmail').addClass('d-none').empty();
                    $('input[name=email]').removeClass('is-invalid');
                }

                if (!error && $('input[name=password]').val() === '') {
                    error = true;
                    $('#errorPassword').removeClass('d-none').text('@lang('passwords.error_missing_password')');
                    $('input[name=password]').addClass('is-invalid').focus();
                }else{
                    $('#errorPassword').addClass('d-none').empty();
                    $('input[name=password]').removeClass('is-invalid');
                }
                
                if(!error)
                    $('form[name=login]')[0].submit();
            })
        });
    </script>
@endsection

@section('body')
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-lg-6">
            <form id="login-form" name="login" action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="email" class="form-control" id="floatingInput"
                        placeholder="@lang('passwords.email_address')">
                    <label for="floatingInput">@lang('passwords.email_address')</label>
                    <div id="errorEmail" class="alert alert-danger d-none"></div>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingPassword"
                        placeholder="@lang('passwords.password')">
                    <label for="floatingPassword">@lang('passwords.password')</label>
                    <div id="errorPassword" class="alert alert-danger d-none"></div>
                </div>
                @if ($errors->has('email'))
                    <div class="alert alert-danger" id="wrongCredentials">
                        @lang('passwords.wrong_credentials')
                    </div>
                @endif

                <div class="form-group text-center mb-3">
                    <label for="login-submit" class="btn btn-primary w-100"><i class="bi bi-door-open"></i>
                        @lang('passwords.login')</label>
                    <input id="login-submit" class="d-none" type="submit" value="Login">
                </div>
            </form>
            <hr>
            </hr>
            <p class="text-center">@lang('passwords.login_redirect') <a href="{{route('register')}}">@lang('passwords.register')</a></p>
        </div>
        <div class="col-12 col-lg-3 d-none d-lg-block">
            <img src="https://colorlib.com/etc/regform/colorlib-regform-7/images/signin-image.jpg" alt="">
        </div>
    </div>

@endsection