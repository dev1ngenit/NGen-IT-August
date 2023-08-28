@extends('frontend.master')
@section('content')
    <style>
        .view-password {
            position: relative;
            left: 8rem;
            bottom: 2.3rem;
        }

        .partner-container {
            background: #fff;
            box-shadow: 0 14px 28px rgba(0, 0, 0, .2), 0 10px 10px rgba(0, 0, 0, .2);
            position: relative;
            overflow: hidden;
            width: 70%;
            margin: auto;
            min-height: 480px;
        }


        .partner-form-container form {
            background: #fff;
            margin-bottom: 3rem;
            display: flex;
            flex-direction: column;
            padding: 25px 70px;
            height: 335px;
            align-items: center;
            text-align: center;
        }


        .partner-social-container a {
            border: 1px solid #ddd;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
        }


        .partner-form-container input {
            background: #eee;
            border: none;
            padding: 10px 20px;
            margin: 8px 0;
            width: 100%;
        }


        .partner-login-button {
            border-radius: 0px;
            border: 1px solid #fff;
            background: #ae0a46;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }


        .partner-login-button:active {
            transform: scale(.95);
        }


        .partner-login-button:focus {
            outline: none;
        }


        .button.ghost {
            background: transparent;
            border-color: #fff;
        }


        .partner-form-container {
            height: 100%;
            transition: all .6s ease-in-out;
        }


        .sign-in-container {
            left: 0;
            z-index: 2;
            margin: auto;
        }


        .sign-up-container {
            left: 0;
            width: 50%;
            z-index: 1;
            /* height: 560px !important; */
            height: 505px !important;
        }


        .sign-up-container form {
            padding: 0 50px !important;
            height: 605px !important;


        }


        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform .6s ease-in-out;
            z-index: 100;
        }


        .overlay {
            background: #ae0a46;
            background: linear-gradient(to right, #ae0a46, #e12268) no-repeat 0 0 / cover;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateY(0);
            transition: transform .6s ease-in-out;
        }


        .overlay-panel {
            position: absolute;
            top: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* padding: 0 40px; */
            padding: 0 30px;
            height: 50%;
            width: 50%;
            text-align: center;
            transform: translateY(0);
            transition: transform .6s ease-in-out;
        }


        .overlay-right {
            right: 0;
            transform: translateY(0);
        }


        .overlay-left {
            transform: translateY(-20%);
        }


        /* Move signin to right */
        .partner-container.right-panel-active .sign-in-container {
            transform: translateY(100%);
        }


        /* Move overlay to left */
        .partner-container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }


        /* Bring signup over signin */
        .partner-container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
        }


        /* Move overlay back to right */
        .partner-container.right-panel-active .overlay {
            transform: translateX(50%);
        }


        /* Bring back the text to center */
        .partner-container.right-panel-active .overlay-left {
            transform: translateY(0);
        }


        /* Same effect for right */
        .partner-container.right-panel-active .overlay-right {
            transform: translateY(20%);
        }


        .footer {
            margin-top: 25px;
            text-align: center;
        }

        .checkbox-wrapper-21 .control {
            display: block;
            position: relative;
            padding-left: 15px;
            cursor: pointer;
            text-align: start;
            font-size: 15px;
        }

        .checkbox-wrapper-21 .control input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .checkbox-wrapper-21 .control__indicator {
            position: absolute;
            top: 4px;
            left: -8px;
            height: 15px;
            width: 15px;
            background: #e6e6e6;
        }

        .checkbox-wrapper-21 .control:hover input~.control__indicator,
        .checkbox-wrapper-21 .control input:focus~.control__indicator {
            background: #ccc;
        }

        .checkbox-wrapper-21 .control input:checked~.control__indicator {
            background: #2aa1c0;
        }

        .checkbox-wrapper-21 .control:hover input:not([disabled]):checked~.control__indicator,
        .checkbox-wrapper-21 .control input:checked:focus~.control__indicator {
            background: #0e647d;
        }

        .checkbox-wrapper-21 .control input:disabled~.control__indicator {
            background: #e6e6e6;
            opacity: 0.6;
            pointer-events: none;
        }

        .checkbox-wrapper-21 .control__indicator:after {
            content: '';
            position: absolute;
            display: none;
        }

        .checkbox-wrapper-21 .control input:checked~.control__indicator:after {
            display: block;
        }

        .checkbox-wrapper-21 .control--checkbox .control__indicator:after {
            left: 5px;
            top: 3px;
            width: 6px;
            height: 8px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-wrapper-21 .control--checkbox input:disabled~.control__indicator:after {
            border-color: #7b7b7b;
        }
    </style>
    <section class="mt-5 mb-3" id="sign-in-container-area">
        <div class="row">
            <div class="col-lg-4 offset-4">
                <div class="partner-form-container sign-in-container mx-auto" style="width: ">
                    <form action="{{ route('client.loginstore') }}" method="POST" id="partnerLoginForm"
                        style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;height: 390px;">
                        @csrf
                        <h2 class="main_color mb-1">Client Login</h2>

                        <input class="mt-3" name="email" type="email" placeholder="Email" />
                        <span class="text-danger text-start p-0 m-0 email_validation" style="display: none;">Please input
                            valid email</span>
                        <input class="mt-3" name="password" type="password" placeholder="Password" />
                        <i class="fas fa-eye transform-v-center view-password"></i>
                        <h6 class="mt-4">Don't Have An Account ? <a href="javascript:void(0);"
                                class="mb-3 mt-2 main_color" id="signUp">Register Now</a></h6>

                        {{-- <a href="#" class="mb-1 mt-3">Forgot your password?</a> --}}
                        <button type="submit" class="partner-login-button mt-4">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container my-3" id="sign-up-container-area" style="display: none">
            <div class="row">
                <div class="col-lg-12">
                    <div class="partner-container mt-3 mb-5" id="partner-login-container">
                        <div class="partner-form-container sign-up-container">

                            <form action="{{ route('clientRegister.store') }}" method="POST" id="partnersignUpForm">
                                @csrf
                                <h2 class="pb-1 pt-0 mt-4 mb-2 main_color">Client Register</h2>
                                <h6>Already Have An Account ?<a href="javascript:void(0);" class="mb-3 main_color"
                                        id="signIn">&nbsp;Sign In Now</a></h6>
                                <input class="input_login registered_name" type="text" name="name"
                                    placeholder="Full name" required value="{{ old('name') }}">
                                <input class="input_login" type="email" name="email" placeholder="Email" required
                                    value="{{ old('email') }}">
                                <span class="text-danger text-start p-0 m-0 email_validation" style="display: none;">Please
                                    input valid email</span>
                                <input class="input_login password_strength" type="password" name="password"
                                    placeholder="Password" required value="{{ old('password') }}">
                                <div id="input_loginStrength" style="display: none;">
                                    Password Strength: <span id="input_loginStrengthIndicator"></span>
                                </div>
                                <input class="input_login confirm_password" type="password" name="password_confirmation"
                                    placeholder="Confirm Password" required>
                                <span class="confirm_message"></span>
                                <div class="checkbox-wrapper-21 mt-2">
                                    <label class="control control--checkbox">
                                        Please Read Our <a href="javascript:void(0);" class="main_color">Policy</a> And
                                        Terms.
                                        <input class="main_color" type="checkbox" checked disabled />
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>
                                <button type="submit" class="partner-login-button mt-3">Sign Up</button>
                            </form>
                        </div>
                        <div class="overlay-container">
                            <div class="overlay">

                                <div class="overlay-panel overlay-right">
                                    <h2 class="text-white">Hello, <span class="welcome_name"></span></h2>
                                    <p>Enter your personal details and start your journey with us</p>
                                    <!-- Your Sign Up form content here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.view-password').on('click', function() {
                let input = $(this).prev("input[name='password']");
                let icon = $(this).toggleClass('fa-eye fa-eye-slash');
                input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            });

            $('.registered_name').on('input', function() {
                var inputVal = $(this).val();
                $('.welcome_name').text(inputVal); // Assuming '.welcome_name' exists elsewhere in your HTML
            });

            $('.confirm_password').on('keyup', function() {
                if ($('.password').val() == $('.confirm_password').val()) {
                    $('.confirm_message').html('Password is matched').css('color', 'green');
                } else {
                    $('.confirm_message').html('Password do not match').css('color', 'red');
                }
            });

            $('input[name="email"]').on("keyup change", function(e) {
                var email = $(this).val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(email)) {
                    $('.email_validation').hide();
                } else {
                    $('.email_validation').show();
                }
            });

            $('#partnerLoginForm').submit(function(event) {
                var email = $('input[name="email"]').val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Please enter a valid email address.');
                    event.preventDefault();
                }
                // Add additional validation if needed
            });

            $('#partnersignUpForm').submit(function(event) {
                var email = $('input[name="email"]').val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Please enter a valid email address.');
                    event.preventDefault();
                }
                // Add additional validation if needed
            });



            // $('.password_strength').keyup(function() {
            $('.password_strength').on('keyup change', function() {

                var password = $(this).val();
                var strengthIndicator = $('#input_loginStrengthIndicator');


                if (password.length > 0) {
                    $('#input_loginStrength').show();
                } else {
                    $('#input_loginStrength').hide();
                }

                // Define password strength criteria (customize as needed)
                var weak = /[a-zA-Z]/.test(password) && password.length < 6;
                var medium = /[a-zA-Z]/.test(password) && /[0-9]/.test(password) && password.length >= 6;
                var strong = /[a-zA-Z]/.test(password) && /[0-9]/.test(password) && /[$@#&!]/.test(
                    password) && password.length >= 8;

                if (strong) {
                    strengthIndicator.text('Strong');
                    strengthIndicator.removeClass().addClass('text-success');
                    $('#input_loginStrength').show();
                } else if (medium) {
                    strengthIndicator.text('Medium');
                    strengthIndicator.removeClass().addClass('text-warning');
                    $('#input_loginStrength').show();
                } else if (weak) {
                    strengthIndicator.text('Weak');
                    strengthIndicator.removeClass().addClass('text-danger');
                    $('#input_loginStrength').show();
                } else {
                    $('#input_loginStrength').hide();
                }
            });



            const $signUpButton = $('#signUp');
            const $signInButton = $('#signIn');
            const $signInContainer = $('#sign-in-container-area');
            const $signUpContainer = $('#sign-up-container-area');

            $signUpButton.on('click', function() {
                $signInContainer.hide();
                $signUpContainer.show();
            });

            $signInButton.on('click', function() {
                $signUpContainer.hide();
                $signInContainer.show();
            });
        });
    </script>
@endsection
