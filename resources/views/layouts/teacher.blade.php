<!DOCTYPE html>
<html lang="en" class="loading semi-dark-layout" data-layout="semi-dark-layout" data-textdirection="ltr">
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

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    @yield('plugin')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item">
                        <a class="nav-link menu-toggle" href="#">
                            <i class="ficon" data-feather="menu"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link nav-link-style">
                            <i class="ficon" data-feather="moon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name fw-bolder text-dark">{{ auth()->guard('teacher')->user()->fullname }}</span>
                            <span class="user-status text-danger fw-bold">Teacher</span>
                        </div>
                        <span class="avatar">
                            <img class="round" src="{{ auth()->guard('teacher')->user()->profile }}" alt="avatar" height="40" width="40" />
                            <span class="avatar-status-online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="{{ route('teacher.profile.index') }}">
                            <i class="me-50" data-feather="user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('teacher.logout') }}">
                            <i class="me-50" data-feather="power"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a href="{{ route('teacher.dashboard') }}" class="navbar-brand">
                        <span class="brand-logo">
                            <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="img-fluid" />
                        </span>
                        <h2 class="brand-text text-white">
                            <span class="text-danger fw-bolder">E</span> - LMS
                        </h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                        <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                        <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class="navigation-header mt-1">
                    <span data-i18n="Informations">Classrooms</span>
                    <i data-feather="more-horizontal"></i>
                </li>

                <li class="nav-item {{ isActive('teacher.dashboard') }}">
                    <a href="{{ route('teacher.dashboard') }}" class="d-flex align-items-center">
                        <i data-feather='columns'></i>
                        <span class="menu-title text-truncate" data-i18n="My Class">My Class</span>
                    </a>
                </li>

                <li class="navigation-header mt-1">
                  <span data-i18n="Informations">Notifications</span>
                  <i data-feather="more-horizontal"></i>
                </li>

                <li class="nav-item {{ isActive('teacher.announcements.index') }}">
                  <a href="{{ route('teacher.announcements.index') }}" class="d-flex align-items-center">
                      <i data-feather='volume-2'></i>
                      <span class="menu-title text-truncate" data-i18n="Announcements">Announcements</span>
                  </a>
                </li>

                <li class="navigation-header mt-1">
                  <span data-i18n="Informations">Activities</span>
                  <i data-feather="more-horizontal"></i>
                </li>

                <li class="nav-item {{ isActive('teacher.modules.index') }}">
                  <a href="{{ route('teacher.modules.index') }}" class="d-flex align-items-center">
                      <i data-feather='file-text'></i>
                      <span class="menu-title text-truncate" data-i18n="Modules">Modules</span>
                  </a>
                </li>

                <li class="nav-item {{ isActive(['teacher.quiz.index', 'teacher.quiz.questions', 'teacher.quiz.results']) }}">
                  <a href="{{ route('teacher.quiz.index') }}" class="d-flex align-items-center">
                      <i data-feather='file-plus'></i>
                      <span class="menu-title text-truncate" data-i18n="Quiz">Quiz</span>
                  </a>
                </li>

                <li class="nav-item {{ isActive(['teacher.assignments.index', 'teacher.assignments.questions', 'teacher.assignments.results']) }}">
                  <a href="{{ route('teacher.assignments.index') }}" class="d-flex align-items-center">
                      <i data-feather='file-minus'></i>
                      <span class="menu-title text-truncate" data-i18n="Assignments">Assignments</span>
                  </a>
                </li>

                <li class="navigation-header mt-1">
                    <span data-i18n="Informations">Users</span>
                    <i data-feather="more-horizontal"></i>
                </li>

                <li class="nav-item {{ isActive('teacher.students.index') }}">
                    <a href="{{ route('teacher.students.index') }}" class="d-flex align-items-center">
                        <i data-feather='user'></i>
                        <span class="menu-title text-truncate" data-i18n="Students">Students</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="app-content content {{ in_array(request()->route()->getName(), ['teacher.quiz.questions', 'teacher.assignments.questions']) ? 'file-manager-application' : null }}" id="app">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="{{ in_array(request()->route()->getName(), ['teacher.quiz.questions', 'teacher.assignments.questions']) ? 'content-area-wrapper' : 'content-wrapper' }} container-xxl p-0">
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

    @include('modals.init')

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