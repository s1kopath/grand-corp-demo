<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css') }}" rel="stylesheet" />

    <!-- datatable css -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatable/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable/buttons.dataTables.min.css') }}">

    <!-- select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- optional css -->
    @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-100">

    @include('layouts.partials.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('layouts.partials.navbar')

        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.modal')

    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/material-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-toggler.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>

    <!-- toast -->
    @include('layouts.partials.simple-toast')

    {{-- datatable --}}
    <script src="{{ asset('assets/js/plugins/datatable/datatable.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatable/jquery.dataTables.min.js') }}"></script>

    {{-- jquery for printable and export datatable --}}
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/buttons.colVis.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/datatable/buttons.colVis.min.js') }}"></script>

    <!-- select2 js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/plugins/select2.init.js') }}"></script>

    <!--custom setup-->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Hidden form for deleting -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- confirm and delete -->
    <script>
        function confirmAndDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You can't undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.setAttribute('action', url);
                    form.submit();
                }
            });
        }
    </script>

    {{-- prevent double submission --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    form.querySelectorAll('[type="submit"]').forEach(button => button.disabled =
                        true);
                });
            });
        });
    </script>

    <!--    Optional JS    -->
    @stack('scripts')
</body>

</html>
