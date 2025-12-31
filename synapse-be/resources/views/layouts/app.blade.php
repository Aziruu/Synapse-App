<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>App Mood Up Lift</title>

    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css') }}/materialdesignicons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css') }}/themify-icons.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/css') }}/vendor.bundle.base.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css') }}/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker') }}/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40jHzYq2VDigF+CIgXrwhwEfnjIKTYhADiEaeoNl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets/css') }}/style.css" />
    <link rel="shortcut icon" href="{{ asset('assets/images') }}/favicon.png" />

    @yield('styles')

</head>
<body>
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo" href="#"><img src="{{ asset('assets/images') }}/logo.svg" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="#"><img src="{{ asset('assets/images') }}/logo-mini.svg" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logout-link">
                            <span class="menu-title">Logout</span>
                            <i class="fa fa-power-off menu-icon"></i>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li> --}}
                </ul>
            </nav>
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
                </div>
            </div>
        </div>

    {{-- Script Source --}}
<script src="{{ asset('assets/vendors/js') }}/vendor.bundle.base.js"></script>
    <script src="{{ asset('assets/vendors/chart.js') }}/chart.umd.js"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker') }}/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('assets/js') }}/off-canvas.js"></script>
    <script src="{{ asset('assets/js') }}/misc.js"></script>
    <script src="{{ asset('assets/js') }}/settings.js"></script>
    <script src="{{ asset('assets/js') }}/todolist.js"></script>
    <script src="{{ asset('assets/js') }}/jquery.cookie.js"></script>
    
    {{-- Script dashboard bawaan template dinonaktifkan --}}
    {{-- <script src="{{ asset('assets/js') }}/dashboard.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('scripts')

    {{-- Alert Js --}}
    <script>
        // Menangkap event klik pada link logout
        document.getElementById('logout-link').addEventListener('click', function(event) {
            // Mencegah link berjalan normal
            event.preventDefault();

            // Menampilkan konfirmasi SweetAlert2
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Anda akan diarahkan ke halaman login.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        });
    </script>
</body>
</html>