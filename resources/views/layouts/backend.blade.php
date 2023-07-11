<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Syed Zayed Hossain">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{url('assets/img/icons/icon-48x48.png')}}" />

    <title>@yield('pagetitle') | {{ config('app.name', 'Laravel') }}</title>

    <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/admin.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="{{url('assets/css/fontawesome.all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="@if (Auth::guard('admin')->check()) {{route('admin.dashboard')}} @elseif (Auth::guard('employee')->check()) {{route('employee.dashboard')}} @endif">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="{{url('assets/img/logo.png')}}" alt="Logo" height="40px">
                </div>
                <div class="sidebar-brand-text mx-3">Techneo<span class="text-dark">360</span></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @if (Auth::guard('admin')->check())
            <li class="nav-item @if (Request::segment(2) == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if (Request::segment(2) == 'employee') active @endif">
                <a class="nav-link" href="{{route('admin.employee')}}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Employee List</span>
                </a>
            </li>
            <!-- report  -->
            <li class="nav-item @if (Request::segment(2) == 'report') active @endif">
                <a class="nav-link" href="{{route('admin.report')}}">
                    <i class="fas fa-flag"></i>
                    <span>Report</span>
                </a>
            </li>
            @elseif (Auth::guard('employee')->check())
            <li class="nav-item @if (Request::segment(2) == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('employee.dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Employee Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if (Request::segment(2) == 'attendance') active @endif">
                <a class="nav-link" href="{{route('employee.attendance')}}">
                    <i class="fas fa-fingerprint"></i>
                    <span>Attendance</span>
                </a>
            </li>
            <!-- report  -->
            <li class="nav-item @if (Request::segment(2) == 'report') active @endif">
                <a class="nav-link" href="{{route('employee.report')}}">
                    <i class="fas fa-flag"></i>
                    <span>Report</span>
                </a>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <h4 id="clock" class="text-primary font-weight-bold"></h4>
                        </li>
                    </ul>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::guard('admin')->check())
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::guard('admin')->user()->name}}</span>
                                @if (Auth::guard('admin')->user()->profile)
                                <img src="{{url(Storage::url(Auth::guard('admin')->user()->profile->image))}}" class="img-profile rounded-circle" alt="Profile Image" width="40px">
                                @else
                                <img src="{{url('assets/img/avatars/avatar.jpg')}}" class="img-profile rounded-circle" alt="Profile Image" width="40px">
                                @endif
                                @elseif (Auth::guard('employee')->check())
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::guard('employee')->user()->name}}</span>
                                @if (Auth::guard('employee')->user()->avatar)
                                <img src="{{Auth::guard('employee')->user()->avatar}}" class="img-profile rounded-circle" alt="Profile Image" width="40px">
                                @else
                                <img src="{{url('assets/img/avatars/avatar.jpg')}}" class="img-profile rounded-circle" alt="Profile Image" width="40px">
                                @endif
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <a class="text-muted" href="https://github.com/zayed259/techneo360_task" target="_blank"><strong>Techneo360</strong></a> - &copy; {{date('Y');}} <a class="text-muted" href="https://www.facebook.com/zayed259" target="_blank"><strong>Syed Zayed Hossain</strong></a>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{url('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{url('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{url('assets/js/admin.min.js')}}"></script>
    <script src="{{url('assets/js/script.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function updateTime() {
            var date = new Date();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();
            var ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;
            hours = hours < 10 ? '0' + hours : hours;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            var time = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
            document.getElementById('clock').textContent = time;
        }
        setInterval(updateTime, 1000);
    </script>
    <script>
        @if(Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @yield('script')

</body>

</html>