@extends('layouts.auth')

@section('content')
    <div class="content-body">
        <div class="auth-wrapper auth-cover">
            <div class="auth-inner row m-0">
                <div class="d-none d-lg-flex col-lg-8 align-items-center">
                    <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                        <img class="img-fluid rounded" src="{{ asset('images/stemobile.jpg') }}" alt="Stemobile" />
                    </div>
                </div>
                <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                        <div class="d-flex justify-content-center align-items-center mb-1">
                            <img src="{{ asset('images/favicon.png') }}" alt="Logo" width="150" height="150" />
                        </div>
                        <h4 class="fw-bold text-center text-dark">
                            <span class="fw-bolder text-danger">E</span>-Learning Management System
                        </h4>

                        <form class="auth-login-form mt-2" action="{{ route('admin.login.store') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <div class="input-group input-group-merge @if (Session::get('login_error')) is-invalid @endif">
                                    <span class="input-group-text">
                                        <i data-feather="user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg @if (Session::get('login_error')) error @endif" 
                                        placeholder="Username" name="username"
                                        value="{{ old('username') }}"
                                        autofocus required />
                                </div>
                                @if($message = Session::get('login_error'))
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <div class="input-group input-group-merge form-password-toggle">
                                    <span class="input-group-text">
                                        <i data-feather="lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg" 
                                        placeholder="Password" name="password" required />
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary w-100" tabindex="4">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection