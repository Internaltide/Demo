<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>

        <!-- Core CSS Applicatable For Gentelella -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Custom Theme Style -->
        <link rel="stylesheet" href="{{ asset('default/css/theme.css') }}">

        <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('pagecss')
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">

                <!-- 1. Side Menu Start -->
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">

                        <!-- menu profile quick info -->
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="{{ route('dashboard') }}" class="site_title" title="{{ config('app.name') }}"><i class="fa fa-cloud"></i> <span>Enterprise Cloud</span></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="profile  clearfix">
                            <div class="profile_pic">
                                <img src="{{ asset('default/images/user.png') }}" alt="" class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2>{{ ucfirst(Auth::user()->user_name) }}</h2>
                            </div>
                        </div>
                        <br />

                        <!-- menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                                <div class="menu_section">
                                    <h3>Domain Handler</h3>
                                    <ul class="nav side-menu">
                                        <li>
                                            <a><i class="fa fa-globe"></i> Domain <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="javascript:;">Domain Mange</a></li>
                                                <li><a href="javascript:;">Application Mange</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="javascript:;">User Mange</a></li>
                                                <li><a href="{{ route('user.perm') }}">Permission Mange</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a><i class="fa fa-cog"></i> Configuration <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="javascript:;">Configuration</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <div class="menu_section"><h3>Booking Handler</h3></div>
                                <div class="menu_section"><h3>Other Handlers</h3></div>

                                <div class="menu_section">
                                    <h3>
                                    <img width="30px" height="30px" src="{{ asset('default/images/laravel-white.png') }}" />&nbsp;&nbsp;Laravel 5.6 Application
                                    </h3>
                                </div>
                        </div>

                        <!-- menu footer button -->
                        <div class="sidebar-footer hidden-small">
                            <a href="javascript:alert('整合式設定頁面，Pendding!!');" data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a href="javascript:alert('站內個人訊息，Pendding!!');" data-toggle="tooltip" data-placement="top" title="Messages">
                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                            </a>
                            <a href="javascript:alert('頁面鎖定，Pendding!!');" data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>

                    </div>
                </div>
                <!-- 1. Side Menu End -->

                <!-- 2. Top Navigation Start -->
                <div class="top_nav">
                        <div class="nav_menu">
                                <nav>
                                    <!-- menu toggle icon -->
                                    <div class="nav toggle">
                                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                                    </div>

                                    <!-- quick func bar -->
                                    <ul class="nav navbar-nav navbar-right">
                                        <!-- profile menu -->
                                        <li class="">
                                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <img src="{{ asset('default/images/user.png') }}" alt="">{{ ucfirst(Auth::user()->user_name) }}
                                                <span class=" fa fa-caret-down"></span>
                                            </a>

                                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                                <li><a href="{{ route('homepage') }}"><i class="fa fa-home pull-right"></i> Home</a></li>
                                                <li><a href="javascript:;"><i class="fa fa-address-card pull-right"></i> Profile</a></li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="badge bg-red pull-right">50% Discount</span>
                                                        <span>New Feature</span>
                                                    </a>
                                                </li>
                                                <li><a href="javascript:;"><i class="fa fa-question-circle pull-right"></i> Help</a></li>
                                                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                            </ul>
                                        </li>

                                        <!-- alert box -->
                                        <li role="presentation" class="dropdown">
                                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-envelope"></i>
                                                <span class="badge bg-green">3</span>
                                            </a>
                                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                                <!-- Alert 1 -->
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="image"><img src="{{ asset('default/images/img4.ico') }}" alt="Profile Image" /></span>
                                                        <span>
                                                            <span>Domain Bot</span>
                                                            <span class="time">3 mins ago</span>
                                                        </span>
                                                        <span class="message">
                                                            Your responsible domain <b>whatsoft.com</b> is due to expire at <b style="color:red;">Nov. 12, 2018.</b>
                                                        </span>
                                                    </a>
                                                </li>

                                                <!-- Alert 2 -->
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="image"><img src="{{ asset('default/images/img3.jpg') }}" alt="Profile Image" /></span>
                                                        <span>
                                                            <span>CRM Bot</span>
                                                            <span class="time">1 weeks ago</span>
                                                        </span>
                                                        <span class="message">
                                                            Your responsible customer <b>IBM's</b> contract is due to expire at <b style="color:red;">Dec. 12, 2018.</b>
                                                        </span>
                                                    </a>
                                                </li>

                                                <!-- Alert Footer -->
                                                <li>
                                                    <div class="text-center">
                                                        <a>
                                                        <strong>See All Alerts</strong>
                                                        <i class="fa fa-angle-right"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                        </div>
                </div>
                <!-- 2. Top Navigation End -->

                <!-- 3. Page Content Start -->
                <div class="right_col" role="main">
                    <div class="">
                        <style>
                            @section('overrideCss')
                                .dm_full_width {
                                    width: 100% !important;
                                }
                            @show
                        </style>

                        @pagetitle(['function' => $function, 'description' => $description])
                        @endpagetitle
                        <div class="clearfix"></div>

                        @yield('content')
                    </div>
                </div>
                <!-- 3. Page Content End -->

                <!-- 4. Footer Start -->
                <footer>
                    <div class="pull-right">
                        @lang('layout.copyright', ['thisyear' => date('Y')])
                    </div>
                    <br/>
                    <div class="pull-right">
                        Theme Design by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <form action="javascript:;">
							<select class="form-control input-sm bfh-languages" data-language="zh" data-available="en,zh,ja"></select>
						</form>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- 4. Footer End -->

            </div>
        </div>

        <!-- Core JS Applicatable For Gentelella -->
        <script src="/js/app.js"></script>

        <!-- Gentelella Custom JS -->
        <script src="/default/js/theme.js"></script>
        <script src="{{ asset('js/smartTools.js') }}"></script>

        <script>
            $(document).ready(function(){
            @section('pagejs')
                    // 訊息通知框
                    @if( Session::has("ntTitle") && Session::has("ntMessage") )
                        var notice = smartTools.Plugin.newNotify(
                            '{{ Session::get("ntTitle") }}',
                            '{{ Session::get("ntMessage") }}',
                            '{{ Session::get('ntType') }}',
                            'click'
                        );
                    @endif
                    // 調整 panel 可以控制預設是否開啟
                    $('.collapse-link').each(function(){
                        var $BOX_PANEL = $(this).closest('.x_panel');

                        if( !$BOX_PANEL.hasClass('dm_open') ){
                            $BOX_PANEL.find('.x_content').slideToggle(200);
                            $BOX_PANEL.css('height', 'auto');
                        } else {
                            $BOX_PANEL.find('#panelctrl').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                        }
                    });
                    // 複選按鈕控制
                    $('div[data-multiBtnSelect="true"] > button').on('click', function(){
                        $(this).toggleClass('btn-info btn-default');
                    });
                    // 單選按鈕控制
                    $('div[data-multiBtnSelect="false"] > button').on('click', function(){
                        $(this).parent().find("button").removeClass('btn-info').addClass('btn-default');
                        $(this).toggleClass('btn-info btn-default');
                    });
                    // 僅用於 Modal 表單裝飾
                    modalDecorate = function(){
                        var modalInput = $('#modal-body').has('input');
                        if( modalInput[0] ){
                            modalInput.iCheck({
                                labelHover: false,
                                cursor: true,
                                checkboxClass: 'icheckbox_flat-green',
                                radioClass: 'iradio_flat-green'
                            });
                        }
                    }
            @show
            });
        </script>
    </body>
</html>