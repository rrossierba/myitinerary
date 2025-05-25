@extends('layouts.master')

@section('title', 'Login')

@section('body')
    <div class="row justify-content-center">
        <div class="col-8 ">
            <form id="login-form" action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="form-group text-center mb-3">
                    <label for="login-submit" class="btn btn-primary w-100"><i class="bi bi-door-open"></i> Login</label>
                    <input id="login-submit" class="d-none" type="submit" value="Login">
                </div>
            </form>
        </div>
    </div>

@endsection