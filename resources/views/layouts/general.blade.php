<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Budget Tool | @yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/morris/morris.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/socicon/socicon.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" />

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/components.min.css') }}" id="style_components" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/plugins.min.css') }}" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/layouts/layout3/css/layout.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/layouts/layout3/css/themes/default.min.css') }}" id="style_color" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/layouts/layout3/css/custom.css') }}" />
        <!-- END THEME LAYOUT STYLES -->

        <link rel="shortcut icon" href="favicon.ico" />
    </head>

    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <div class="page-wrapper-row">


                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
                            <div class="container">
                                <!-- BEGIN LOGO -->
                                <div class="page-logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('logo.png') }}" class="logo-default" height="20">
                                    </a>
                                </div>
                                <!-- END LOGO -->

                                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <a href="javascript:;" class="menu-toggler"></a>
                                <!-- END RESPONSIVE MENU TOGGLER -->


                                <div class="top-menu">

                                    @auth

                                        <ul class="nav navbar-nav pull-right">
                                            <!-- BEGIN USER LOGIN DROPDOWN -->
                                            <li class="dropdown dropdown-user dropdown-dark">
                                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

                                                    @if (Auth::user()->avatar == 'N/A')
                                                        <img alt="" class="img-circle" src="{{ asset('assets/layouts/layout3/img/avatar.png') }}">
                                                    @else
                                                        <img alt="" class="img-circle" src="{{ Auth::user()->avatar }}">
                                                    @endif

                                                    <span class="username username-hide-mobile">{{ Auth::user()->name }}</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-default">
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-user"></i>
                                                            {{ Auth::user()->email }}
                                                        </a>
                                                    </li>
                                                    <li class="divider"> </li>
                                                    <li>
                                                        <a href="{{ url('login/close') }}">
                                                            <i class="icon-key"></i> Log Out </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <!-- END USER LOGIN DROPDOWN -->
                                        </ul>

                                    @else

                                        <div class="socicons">
                                            <a href="{{ url('/login/google') }}" class="socicon-btn socicon-btn-circle socicon-solid bg-red font-white bg-hover-blue socicon-google tooltips"></a>
                                        </div>

                                    @endauth

                                </div>
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
                        <!-- BEGIN HEADER MENU -->
                        <div class="page-header-menu">
                            <div class="container">

                                <!-- BEGIN MEGA MENU -->
                                <div class="hor-menu">

                                    @auth

                                        <ul class="nav navbar-nav">
                                            <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown @if(Request::is('/')) active @endif">
                                                <a href="{{ url('/') }}">
                                                    <i class="icon-graph"></i>
                                                    Dashboard
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>
                                            <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(Request::is('budget')) active @endif ">
                                                <a href="{{ url('budget') }}">
                                                    <i class="fa fa-calculator"></i>
                                                    Budget
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>

                                            <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(Request::is('configurations/*')) active @endif ">
                                                <a href="{{ url('configurations') }}">
                                                    <i class="fa fa-wrench"></i>
                                                    Configurations
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>

                                            <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(Request::is('family')) active @endif ">
                                                <a href="{{ url('family') }}">
                                                    <i class="fa fa-group"></i>
                                                    Family
                                                    <span class="arrow"></span>
                                                </a>
                                            </li>

                                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                                <li aria-haspopup="true" class="menu-dropdown mega-menu-dropdown @if(Request::is('admin/*')) active @endif">
                                                    <a href="javascript:;">
                                                        <i class="fa fa-wrench"></i>
                                                        Admin
                                                        <span class="arrow"></span>
                                                    </a>
                                                    <ul class="dropdown-menu pull-left">
                                                        <li aria-haspopup="true" class=" @if(Request::is('admin/family/*')) active @endif ">
                                                            <a href="{{ url('/admin/families') }}" class="nav-link  ">
                                                                <i class="fa fa-group"></i>
                                                                Families
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endif
                                        </ul>

                                    @endauth

                                </div>
                                <!-- END MEGA MENU -->
                            </div>
                        </div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">

                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container">
                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title">

                                        @yield('header')

                                    </div>
                                    <!-- END PAGE TITLE -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">

                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="mt-content-body">
                                            <div class="row">

                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-12">
                                                            @yield('content')
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->

                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>

            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                    <!-- BEGIN FOOTER -->
                    <div class="page-footer">
                        <div class="container">
                            <div class="row">
                                <div class="container"> 2018 &copy; Budget Tool by
                                    <a target="_blank" href="https://www.carth.org">Carth Studios</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                    </div>
                    <!-- END FOOTER -->
                </div>
            </div>
        </div>

        <!-- BEGIN CORE PLUGINS -->
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/js.cookie.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script type="text/javascript" src="{{ asset('assets/global/plugins/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/morris/morris.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/counterup/jquery.counterup.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/flot/jquery.flot.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/flot/jquery.flot.resize.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/flot/jquery.flot.categories.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}"></script>

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script type="text/javascript" src="{{ asset('assets/global/scripts/app.min.js') }}"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script type="text/javascript" src="{{ asset('assets/pages/scripts/components-date-time-pickers.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/pages/scripts/ui-confirmations.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/pages/scripts/ui-sweetalert.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/pages/scripts/components-bootstrap-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/pages/scripts/dashboard.min.js') }}"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script type="text/javascript" src="{{ asset('assets/layouts/layout3/scripts/layout.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/layouts/layout3/scripts/demo.min.js') }}"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

    </body>
</html>