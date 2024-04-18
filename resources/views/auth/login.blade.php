<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ottoman Construction - Login page">
    <meta name="keywords" content="Ottoman Construction">
    <meta name="author" content="Ottoman Construction">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <title>Login - Ottoman Construction</title>
    
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/all.min.css') }}"  />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>
    <div class="page-wrapper">
        <div class="authentication-box">
            <div class="container-fluid">
                <div class="row log-in">
                    <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-6 col-sm-8 form-login">
                        <div class="card">
                            <div class="card-body">
                                <div class="title-3 text-start">
                                    <h2>Login</h2>
                                </div>
                                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text px-2">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Enter Email" autocomplete="off" value="{{ old('email') }}" name="email">
                                        </div>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text px-2">
                                                    <i class="fa-solid fa-lock"></i>
                                                </div>
                                            </div>
                                            <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off"  value="{{ old('email') }}" name="password">
                                            <div class="input-group-apend">
                                                <div class="input-group-text mx-2">
                                                    <a href="javascript:void(0)" onclick="show_hide_password();"><i class="fa-regular fa-eye" id="password_icon"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-gradient btn-pill color-2 me-sm-3 me-2 px-5">Log in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-7 offset-xxl-1 col-lg-6 auth-img">
                        <img src="{{ asset('assets/images/logo.png') }}" class="bg-img w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!--<script src="{{ asset('assets/font-awesome/all.min.js') }}"></script>-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!--<script src="{{ asset('assets/font-awesome/all.min.js') }}"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/admin-script.js') }}"></script>
    <script src="{{ asset('assets/js/login.js') }}"></script>
   
    <script>
        function show_hide_password()
        {
            var type = $("#password").attr("type");
            type = type == "password" ? "text" : "password";
            var icon_class = type == "password" ? "fa-eye" : "fa-eye-slash";
            var type = $("#password").attr("type",type);
            $("#password_icon").removeClass('fa-eye');
            $("#password_icon").removeClass('fa-eye-slash');
            $("#password_icon").addClass(icon_class);
        }
    </script>
</body>
</html>
