
<!DOCTYPE html>
<html lang="en">
    <head>
      @include('home-partials.meta')
      @include('home-partials.css')
	 
      @yield('styles')

    </head>
    <body>
       <div class="dashboard-main-wrapper">

             @include('home-partials.header')
            <div class="page-content">
                <!-- wrapper  -->
                <div class="dashboard-wrapper page-content-div">
                    <div class="dashboard-ecommerce">
                        <div class="container-fluid dashboard-content ">
                            
                            <!-- responsive table -->
                            @yield('content')
                            <!-- end responsive table -->
                        </div>
                    </div>
                </div>
            </div>
 </div>



          @yield('modal')
        @include('home-partials.js')
      

    </body>
	
</html>
