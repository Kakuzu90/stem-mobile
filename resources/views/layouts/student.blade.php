<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @yield('title')
  </title>
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
  <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/extensions/toastr.min.css') }}">

  @yield('link_vendor')
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
  @yield('plugin')

  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="horizontal-layout horizontal-menu  navbar-floating footer-static" data-open="click" data-menu="horizontal-menu" data-col="">

  <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow" data-nav="brand-center">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                  <a class="nav-link menu-toggle d-flex align-items-center" href="{{ route('student.home') }}">
                    <img src="{{ asset('images/favicon.png') }}" height="35" width="35" alt="Stemobile" />
                    <span class="ms-25 font-medium-3 fw-bolder text-dark"><span class="text-danger">E</span>-LMS</span>
                  </a>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item d-none d-lg-block">
              <a class="nav-link nav-link-style">
                <i class="ficon" data-feather="moon"></i>
              </a>
            </li>
            <li class="nav-item dropdown dropdown-user">
              <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user-nav d-sm-flex d-none">
                  <span class="user-name fw-bolder">{{ auth()->guard('student')->user()->fullname }}</span>
                  <span class="user-status fw-bold text-danger">Student</span>
                </div>
                <span class="avatar">
                  <img class="round" src="{{ auth()->guard('student')->user()->profile }}" alt="avatar" height="40" width="40"/>
                  <span class="avatar-status-online"></span>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                <a class="dropdown-item" href="page-profile.html">
                  <i class="me-50" data-feather="user"></i> Profile
                </a>
                <a class="dropdown-item" href="{{ route('student.logout') }}">
                  <i class="me-50" data-feather="power"></i> Logout
                </a>
              </div>
            </li>
        </ul>
    </div>
  </nav>

  <div class="app-content content" style="padding-top: 6.8rem;" id="app">
    <div class="content-overlay"></div>
    <div class="content-wrapper container-xxl p-0">
      @yield('body')
    </div>
  </div>
  
  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>
  <footer class="footer footer-static footer-light">
      <p class="clearfix mb-0">
          <span class="float-md-start d-block d-md-inline-block mt-25">
              COPYRIGHT &copy; 2023
              <a class="ms-25" href="{{ route('teacher.dashboard') }}" target="_blank">E-Learning Management System</a>
              <span class="d-none d-sm-inline-block">, All rights Reserved</span>
          </span>
          <span class="float-md-end d-none d-md-block">
              Developed By:
              <a href="https://www.facebook.com/clyde.arellano.31" target="_blank">
              <i data-feather='facebook'></i>
              </a>
          </span>
      </p>
  </footer>
  <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
  
  <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
  <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
  @yield('script_vendor')
  <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
  <script src="{{ asset('app-assets/js/core/app.js') }}"></script>

  @include('toastr')

  @yield('scripts')

  <script>
      $(window).on('load', function() {
          if (feather) {
              feather.replace({
                  width: 14,
                  height: 14
              });
          }
      })
  </script>
</body>
</html>