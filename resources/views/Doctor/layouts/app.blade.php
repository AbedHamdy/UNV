<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    @include("Doctor.layouts.header")

</head>

<body>
    <!-- Menu icon -->

    @include("Doctor.layouts.nav");

    <!-- Sidebar -->

    @include("Doctor.layouts.sidebar");

    <!-- Content -->
    <div class="content" id="mainContent">

        @yield("content")
        

    </div>

    <!-- Footer -->

    @include("Doctor.layouts.footer");

    @include("Doctor.layouts.script");

</body>

</html>
