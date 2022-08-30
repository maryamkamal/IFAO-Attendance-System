<!DOCTYPE html>
<html lang="en">
    <head>

      @include('login-partials.meta')
      @include('login-partials.css')
      @yield('styles')

    </head>

    <body>
      
        @yield('content')
        @include('login-partials.js')
        @yield('javascripts')
    </body>
</html>
