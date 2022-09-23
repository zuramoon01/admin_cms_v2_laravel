@props(['menus'])

<!DOCTYPE html>
<html lang="en">

<head>
    <x-partials._head-content />
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <x-dashboard.partials._sidebar :menus="$menus" />

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <x-dashboard.partials._topbar />

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <x-dashboard.partials._footer />

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <x-dashboard.partials._scroll-to-top />

    <x-dashboard.partials._logout-modal />

    @isset($js)
        {{ $js }}
    @endisset

    <x-partials._js />

</body>

</html>
