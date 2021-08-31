
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('admin-theme/custom/login.css')}}">
    <!-- Box Icons -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <!-- Container -->
    <div class="container" id="container">
        <!-- Row -->
        <div class="row">
            <!-- Sign Up -->
            <div class="col align-center flex-col sign-up">
                <div class="form-wrapper align-center">
                    <form class="form sign-up" method="POST">
                    @csrf
                        <div class="input-group">
                            <i class="bx bxs-user"></i>
                            <input type="text" name="name" placeholder="Username" value="{{old('name')}}"/>
                        </div>
                        <div class="input-group">
                            <i class="bx bx-mail-send"></i>
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}"/>
                        </div>
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="Password" name="password"/>
                        </div>
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="Confirm password" name="cfpassword"/>
                        </div>
                        <button type="submit" disabled>Sign up</button>
                        <span>Already have an account?</span>
                        <b id="sign-up">Sign in here</b>
                    </form>
                </div>
                <!-- Social Wrapper -->
                <div class="form-wrapper">
                    <div class="social-list align-center sign-up">
                        <div class="align-center facebook-bg">
                            <i class="bx bxl-facebook"></i>
                        </div>
                        <div class="align-center google-bg">
                            <i class="bx bxl-google"></i>
                        </div>
                        <div class="align-center twitter-bg">
                            <i class="bx bxl-twitter"></i>
                        </div>
                        <div class="align-center insta-bg">
                            <i class="bx bxl-instagram-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- End Social Wrapper -->
            </div>
            <!-- End Sign Up -->
            <!-- Sign In -->
            <div class="col align-center flex-col sign-in">
                <div class="form-wrapper align-center">
                    <form class="form sign-in" method="POST">
                    @if(session('msg') != null)
                    <p class="alert-top">{{session('msg')}}</p>
                    @endif
                    @csrf
                        <div class="input-group">
                            <i class="bx bxs-user"></i>
                            <input type="text" placeholder="Email" name="email" value="{{old('email')}}">
                        </div>
                        @error('email')
                        <p class="alert">
                            {{ $message }}
                        </p>
                        @enderror
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                        @error('password')
                        <p class="alert">
                            {{ $message }}
                        </p>
                        @enderror
                        <div class="remember-group">
                            <input type="checkbox" class="remember" id="remember" disabled>
                            <label for="remember" class="rmbtk">Remember Me</label>
                        </div>
                        <button type="submit">Sign In</button>
                        <p>
                            <b>Forgot password</b>
                        </p>
                        <span>Don't have and account?</span>
                        <b id="sign-in">Sign up here</b>
                    </form>
                </div>
                <!-- Social Wrapper -->
                <div class="form-wrapper">
                    <div class="social-list align-center sign-in">
                        <div class="align-center facebook-bg">
                            <i class="bx bxl-facebook"></i>
                        </div>
                        <div class="align-center google-bg">
                            <i class="bx bxl-google"></i>
                        </div>
                        <div class="align-center twitter-bg">
                            <i class="bx bxl-twitter"></i>
                        </div>
                        <div class="align-center insta-bg">
                            <i class="bx bxl-instagram-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- End Social Wrapper -->
            </div>
            <!-- End Sign In -->
        </div>
        <!-- End Row -->

        <!-- Content Section -->
        <div class="row content-row">
            <!-- Sign in content -->
            <div class="col align-center flex-col">
                <div class="text sign-in">
                    <h2>Welcome Back</h2>
                    <P>
                        Buồn làm chi em ơi, lá xanh rồi cũng phai màu, Ngỡ duyên mình bền lâu, ai ngờ lại xa cách nhau, Trăng treo trên mái đầu, tâm tư nên âu sầu, Qua bao nhiêu rãi rầu, mà lại nỡ qua cầu sang ngang
                    </P>
                </div>
                <div class="img sign-in">
                    <img src="{{ asset('admin-theme/dist/img/doraemon1.png')}}" alt="">
                </div>
            </div>
            <!-- End Sign in content -->
            <!-- Sign up content -->
            <div class="col align-center flex-col">
                <div class="text sign-up">
                    <h2>Join with us</h2>
                    <P>
                        Buồn làm chi em ơi, lá xanh rồi cũng phai màu, Ngỡ duyên mình bền lâu, ai ngờ lại xa cách nhau, Trăng treo trên mái đầu, tâm tư nên âu sầu, Qua bao nhiêu rãi rầu, mà lại nỡ qua cầu sang ngang
                    </P>
                </div>
                <div class="img sign-up">
                    <img src="{{ asset('admin-theme/dist/img/doraemon2.png')}}" alt="">
                </div>
            </div>
            <!-- End Sign up content -->
        </div>
    </div>
    <!-- End Container -->
    <!-- Js -->
    <script>
        const container = document.getElementById("container");
        const signIn = document.getElementById("sign-in");
        const signUp = document.getElementById("sign-up");

        setTimeout(() => {
            container.classList.add("sign-in");
        }, 200);

        const toggle = () => {
            container.classList.toggle("sign-in");
            container.classList.toggle("sign-up");
        };

        signIn.addEventListener("click", toggle);
        signUp.addEventListener("click", toggle);
    </script>
</body>

</html>