<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Css -->
    <link rel="icon" type="image/x-icon" href="{{ asset('client-theme/images/logo.png')}}">
    @include('layouts.client.style')
    @yield('pageStyle')
</head>

<body>
    <!-- Header - Start -->
    @include('layouts.client.header')
    <!-- Header - End -->

    <!-- Content Start -->
    @yield('content')
    <!-- Content End -->

    <!-- 
      * scroll to top 
      * start
    -->
    <button id="scrollToTop" class="scrollToTop">
        <i class="fas fa-chevron-up"></i>
    </button>
    <!-- 
      * scroll to top 
      * end
    -->

    <!-- Footer - Start -->
    @include('layouts.client.footer')
    <!-- Footer - End -->
    <!-- JS -->
    @include('layouts.client.script')
    @yield('pagejs')
    <!-- end JS -->
</body>

</html>