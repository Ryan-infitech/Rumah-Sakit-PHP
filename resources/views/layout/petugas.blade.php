<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - Staff Portal</title>
    
    <!-- Custom fonts and styles -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-petugas') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Portal Petugas</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('dashboard-petugas') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard-petugas') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('pasien.create') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien.create') }}">
                    <i class="fas fa-fw fa-user-plus"></i>
                    <span>Pendaftaran Pasien Baru</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.registration') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.registration') }}">
                    <i class="fas fa-fw fa-calendar-plus"></i>
                    <span>Pendaftaran Poliklinik</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('antrian.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('antrian.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan Pendaftaran</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('petugas.antrian') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('petugas.antrian') }}">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Antrian Hari Ini</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('petugas.rekam-medis') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('petugas.rekam-medis') }}">
                    <i class="fas fa-fw fa-file-medical"></i>
                    <span>Rekam Medis</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('pasien.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Pasien</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama_user }}</span>
                                @if(Auth::user()->foto_user)
                                    <img class="img-profile rounded-circle" src="{{ asset('storage/foto_user/' . Auth::user()->foto_user) }}" alt="{{ Auth::user()->nama_user }}">
                                @else
                                    <img class="img-profile rounded-circle" src="{{ asset('img/default.jpg') }}" alt="Default Profile">
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="logout-menu-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <input type="hidden" id="success-message" value="{{ session('success') }}">
                    <input type="hidden" id="error-message" value="{{ session('error') }}">
                    
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Rumah Sakit Dr. Rian 2023</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Core Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.getElementById('logout-menu-item').addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Yakin untuk keluar?',
                text: 'Pilih "Logout" jika kamu yakin untuk meninggalkan halaman ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            if (successMessage && successMessage.value) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage.value,
                    timer: 3000,
                    timerProgressBar: true
                });
            }

            if (errorMessage && errorMessage.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage.value,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
