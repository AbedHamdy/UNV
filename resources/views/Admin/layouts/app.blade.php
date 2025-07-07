<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    @include("Admin.layouts.header")

</head>

<body>
    <!-- Menu icon (fixed) -->

    @include("Admin.layouts.nav")

    <!-- Sidebar -->

    @include("Admin.layouts.sidebar")

    <!-- Main Content -->

    <div class="content" id="mainContent">
        @yield("content")
    </div>

    <!-- Footer -->

    @include("Admin.layouts.footer")

    @include('Admin.layouts.script')

</body>

</html>
