@extends('layouts.master')

@section('title', 'Register')

@section('body')
<div class="row justify-content-center">
        <div class="col-8 ">
            <form id="register-form" action="{{ route('register') }}" method="post">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Name">
                    <label for="floatingInput">Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address">
                    <label for="floatingInput">Email address</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password_confirmation" id="floatingPassword" placeholder="Confirm Password">
                    <label for="floatingPassword">Confirm Password</label>
                </div>
        
                <div class="form-group text-center mb-3">
                    <label for="register-submit" class="btn btn-primary w-100"><i class="bi bi-person-plus"></i> Register</label>
                    <input id="register-submit" class="d-none" type="submit" value="Register">
                </div>
            </form>
        </div>
</div>

@endsection