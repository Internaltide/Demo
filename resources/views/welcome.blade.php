<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                //color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 800;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                //color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .backgroundimg{
                background-image: url('../default/images/home-background.jpg');
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height backgroundimg">
            @if (Route::has('login'))
                <div class="top-right links">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ route('dashboard') }}">Administrator Backend</a>
                    @auth
                        <a href="{{ route('logout') }}">Logout</a>
                    @else
                        <a href="{{ route('loginform') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Personal Blog Site
                </div>

                <!-- My Documents -->
                <div class="links">
                    <label><b>DOCUMENTS</b></label>
                    <a href="https://github.com/Internaltide/Laradep#laradep" target="_blank">Laradep</a>
                    <a href="https://github.com/Internaltide/Laradep#laravel-topic" target="_blank">Laravel Framework</a>
                    <a href="https://github.com/Internaltide/dp2dp" target="_blank">Design Pattern</a>
                    <a href="https://github.com/Internaltide/casestudy" target="_blank">Case Study</a>
                </div>
                <hr size="3" width="100%">

                <!-- My Side Projects -->
                <br/><br/><label><b>Side Projects</b></label><br/><br/>
                <div class="links">
                    <a href="{{ route('dashboard') }}">Cloud Enterprise Domain Handler</a>
                    <a href="{{ route('homepage') }}">......</a>
                </div>

                <!-- My Favorite Sits -->
                <br/><br/><br/><br/><hr size="3" width="35%">
                <div class="links">
                    <a href="https://gitlab.com/internaltide/domainManager" target="_blank">My GitLab</a>
                    <a href="https://github.com/Internaltide" target="_blank">My GitHub</a>
                </div><br/><br/>
            </div>
        </div>
    </body>
</html>
