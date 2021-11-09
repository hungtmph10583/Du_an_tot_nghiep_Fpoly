
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
    <div class="container sign-up" id="container">
        <!-- Row -->
        <div class="row">
            <!-- Sign Up -->
            <div class="col align-center flex-col sign-up">
                <div class="form-wrapper align-center">
                    <form class="form sign-up" method="POST">
                    @csrf
                        <h1 class="title">Change Password</h1>
                        @if(session('error') != null)
                            <p class="alert-top">{{session('error')}}</p>
                        @endif
                        @if(session('success') != null)
                            <p class="success-top">{{session('success')}}</p>
                        @endif
                        <div class="input-group">
                            <i class="bx bx-mail-send"></i>
                            <input type="text" name="email" placeholder="Email" value="{{Auth::user()->email}}"/>
                        </div>
                        @error('email')<p class="alert">{{ $message }}</p>@enderror
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="Current Password" name="currentpassword"/>
                        </div>
                        @error('currentpassword')<p class="alert">{{ $message }}</p>@enderror
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="New Password" name="newpassword"/>
                        </div>
                        @error('newpassword')<p class="alert">{{ $message }}</p>@enderror
                        <div class="input-group">
                            <i class="bx bxs-lock-alt"></i>
                            <input type="password" placeholder="Confirm password" name="cfpassword"/>
                        </div>
                        @error('cfpassword')<p class="alert">{{ $message }}</p>@enderror
                        <button type="submit">Submit</button>
                        <p>
                            <a href="{{route('client.home')}}" style="font-size:1rem;">Quay về trang chủ</a>
                        </p>
                        <span>Already have an account?</span>
                        <a href="{{route('login')}}" class="link">Sign in</a>
                    </form>
                </div>
            </div>
            <!-- End Sign Up -->
            <!-- Sign In -->
            <div class="col align-center flex-col sign-in"></div>
            <!-- End Sign In -->
        </div>
        <!-- End Row -->

        <!-- Content Section -->
        <div class="row content-row">
            <!-- Sign in content -->
            <div class="col align-center flex-col"></div>
            <!-- End Sign in content -->
            <!-- Sign up content -->
            <div class="col align-center flex-col">
                <div class="text sign-up">
                    <h2>Change Password</h2>
                    <P>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis provident excepturi possimus magni dignissimos maiores rem quo pariatur distinctio corrupti, quod ipsam ducimus repudiandae quam! Blanditiis officiis deleniti recusandae laboriosam.
                    </P>
                </div>
                <div class="img sign-up">
                    <img src="{{ asset('admin-theme/dist/img/doraemon2.png')}}" alt="">
                </div>
            </div>
            <!-- End Sign up content -->
        </div>
    </div>
</body>

</html>