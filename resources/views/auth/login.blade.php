
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
    <div class="container sign-in" id="container">
        <!-- Row -->
        <div class="row">
            <div class="col align-center flex-col sign-up"></div>
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
                            <input type="text" name="email" placeholder="Email" value="{{old('email')}}">
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
                            <input type="checkbox" value="remember" class="remember" id="remember" name="remember">
                            <label for="remember" class="remember">Remember Me</label>
                        </div>
                        <button type="submit">Sign In</button>
                        <p>
                            <a href="{{route('forgotPassword')}}" class="link">Forgot password</a>
                        </p>
                        <span>Don't have and account?</span>
                        <a href="{{route('registration')}}" class="link">Sign up here</a>
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
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis provident excepturi possimus magni dignissimos maiores rem quo pariatur distinctio corrupti, quod ipsam ducimus repudiandae quam! Blanditiis officiis deleniti recusandae laboriosam.
                    </P>
                </div>
                <div class="img sign-in">
                    <img src="{{ asset('admin-theme/dist/img/doraemon1.png')}}" alt="">
                </div>
            </div>
            <!-- End Sign in content -->
        </div>
    </div>
    <!-- End Container -->
    <!-- Js -->
    <!-- <script>
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
    </script> -->
</body>

</html>