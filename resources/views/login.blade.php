<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        html,
        body {
            height: 100%;
            background: url("image/background.jpg");
            background-size: 100%;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .global-container {
            height: 85%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            width: 400px;
            padding: 25px;
            background-color: rgb(237, 237, 237);
            border-radius: 10px;
            box-shadow: 5px 10px 18px rgb(0, 136, 255);
        }

        input[type="login-username"],
        input[type="login-password"] {
            background: rgb(239, 239, 239);
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 0 0 0.3px black;
        }
    </style>
    <title>Company Form</title>
</head>



<body>
    <div class="global-container">
        <div class="card login-form">

            <img src="image/logo.png" alt="Logo" style="display: block; margin: auto; width: 200px;">

            <div class="card-body">
                <h5 class="card-title" style="text-align: center; color: black">Company</h5>
            </div>
            <div class="card-text">
                <form id="loginform" class="form-horizontal" role="form" action={{ url('/login') }} method="post">
                    @csrf
                    @if (session()->has('gagal'))
                        <div class="alert alert-danger ">
                            {{ session('gagal') }}
                        </div>
                    @endif
                    @if (session('gud'))
                        <div class="alert alert-success ">
                            {{ session('gud') }}
                        </div>
                    @endif
                    <div class="mb-1">
                        <label for="login-username" class="form-label" style="color: black">
                            Username
                        </label>
                        <input type="userlogin" class="form-control" id="login-username" name="EmailAddress"
                            placeholder="Username">
                    </div>
                    <div class="mb-2">
                        <label for="login-password" class="form-label" style="color: black">
                            Password
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="login-password"
                                placeholder="Password">
                            <button class="btn btn-outline-secondary" type="button" id="password-toggle">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <script>
                        const passwordField = document.getElementById('login-password');
                        const passwordToggle = document.getElementById('password-toggle');
                        const eyeIcon = passwordToggle.querySelector('i');

                        passwordToggle.addEventListener('click', function() {
                            if (passwordField.type === 'password') {
                                passwordField.type = 'text';
                                eyeIcon.classList.remove('bi-eye-slash');
                                eyeIcon.classList.add('bi-eye');
                            } else {
                                passwordField.type = 'password';
                                eyeIcon.classList.remove('bi-eye');
                                eyeIcon.classList.add('bi-eye-slash');
                            }
                        });
                    </script>




                    {{-- <br> --}}
                    <br>
                    <div class="alert alert-danger ">
                        <b>Note:</b> Please log in using your Company user account
                    </div>
                    <div style="text-align: center;">
                        <div style="display:grid;">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-success btn-lg">Login</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <div id="overlay">
        <div class="w-100 d-flex justify-content-center align-items-center">
            <div class="spinner"></div>
        </div>
    </div>
</body>

<script>
    window.onbeforeunload = function() {
        spinner();
    };

    function spinner() {
        document.getElementById("overlay").style.display = "flex";
    }

    function spinneroff() {
        document.getElementById("overlay").style.display = "none";
    }
</script>
