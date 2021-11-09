
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            <div class="col align-center flex-col sign-up"></div><!--  Ko duoc xoa -->
            <div class="col align-center flex-col sign-in">
                <div class="form-wrapper align-center">
                    <form class="form sign-in" method="POST">
                        <h1 class="title">Forgot Password</h1>
                    @csrf
                    @if(session('msg') != null)
                    <p class="alert-top">{{session('msg')}}</p>
                    @endif
                        <div class="input-group">
                            <i class="bx bxs-user"></i>
                            <input type="text" placeholder="Email" name="email" value="{{old('email')}}">
                        </div>
                        @error('email')
                        <p class="alert">
                            {{ $message }}
                        </p>
                        @enderror
                        <button type="submit">Submit</button>
                        <span>Already have an account?</span>
                        <a href="{{route('login')}}" class="link">Sign in here</a>
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
                    <h2>Forgot Password</h2>
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
</body>

</html>