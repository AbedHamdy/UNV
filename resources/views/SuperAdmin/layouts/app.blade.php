<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        @include('SuperAdmin.layouts.header')
    </head>

    <body>
        
        <!-- Navbar -->
        @include("SuperAdmin.layouts.nav")

        <!-- Sidebar -->
        @include("SuperAdmin.layouts.sidebar")

        <!-- Main Content -->
        <div class="content" id="mainContent">
            @yield("content")
        </div>

        <!-- Footer -->
        @include("SuperAdmin.layouts.footer")

        @include('SuperAdmin.layouts.script')
    </body>

</html>
