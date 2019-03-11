<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ config('app.name') }}</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link rel="stylesheet" href="default/css/login.css" />
    </head>
    <body>
        <!-- Header -->
        <div class="login-header row-container">
        </div>

        <!-- Main Content -->
        <div class="login-main col-container">
            <!-- production logo -->
            <div class="logo">
              <a href="{{ route('homepage') }}"><img src="default/images/logo.png" height="77px" width="300px"/></a>
            </div>

            <!-- login form -->
            <div class="login-form">
              <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                <div class="form-code">
                    <div class="input-group">
                        <label class="input-group-addon login-code" for="login_account">
                                <i class="fas fa-user-alt"></i>&nbsp; @lang('login.account')
                        </label>
                    <input type="text" class="form-control" id="login_account" name="{{ $username }}" value="{{ old($username) }}" placeholder="  @lang('login.accholder')"  />
                    </div>
                    <div class="input-group">
                            <label class="input-group-addon login-code" for="login_password">
                                    <i class="fas fa-lock"></i>&nbsp; @lang('login.password')
                            </label>
                            <input type="password" class="form-control" id="login_password" name="{{ $password }}" />
                    </div>

                    <!-- Login Error Messages -->
                    <div class="">
                        <center>
                            <!-- Error Icon -->
                            @if( $errors->any() || session('fail') )
                            <i class="fa fa-exclamation-triangle" style="color:red;"></i>
                            @endif

                            <!-- Error Msg -->
                            <span style="color:red">
                                @if(session('fail'))
                                {{ session('fail') }}
                                @endif
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                    {{  $error }}<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endforeach
                                @endif
                            </span>
                        </center>
                    </div>
                </div>

                <div class="form-login-btn">
                    <div class="btn-group">
                        <button class="btn-login" id="login">@lang('login.login')</button>
                        <button class="btn-forget" id="forget">@lang('login.forget')</button>
                        <!--<i class="fab fa-facebook-square fa-3x"></i>
                        <i class="fab fa-google fa-3x"></i>
                        <i class="fab fa-line fa-3x"></i>
                        <i class="fab fa-linkedin fa-3x"></i>
                        <i class="fab fa-medium fa-3x"></i>
                        <i class="fab fa-microsoft fa-3x"></i>
                        <i class="fab fa-twitter-square fa-3x" style="color:red;"></i>-->
                    </div>
                </div>
                {{ csrf_field() }}
              </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="login-footer row-container">
            <div class="copyright">
                @lang('login.copyright', ['thisyear' => date('Y')])
            </div>
        </div>
    </body>
</html>