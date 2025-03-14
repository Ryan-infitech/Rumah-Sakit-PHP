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
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-petugas') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Portal Petugas</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard-petugas') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard-petugas') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pendaftaran
            </div>

            <!-- Nav Item - Registration -->
            <li class="nav-item {{ request()->routeIs('pasien.create') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien.create') }}">
                    <i class="fas fa-fw fa-user-plus"></i>
                    <span>Pasien Baru</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.registration') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.registration') }}">
                    <i class="fas fa-fw fa-notes-medical"></i>
                    <span>Pendaftaran Poliklinik</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Layanan Pasien
            </div>

            <!-- Nav Item - Queue Management -->
            <li class="nav-item {{ request()->routeIs('petugas.antrian') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('petugas.antrian') }}">
                    <i class="fas fa-fw fa-clipboard-list"></i>
                    <span>Antrian Hari Ini</span>
                    @php
                        $waitingCount = App\Models\Antrian::whereDate('tanggal_berobat', now()->format('Y-m-d'))
                            ->where('status', 'menunggu')
                            ->count();
                    @endphp
                    @if($waitingCount > 0)
                        <span class="badge badge-pill badge-danger ml-2">{{ $waitingCount }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('petugas.rekam-medis') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('petugas.rekam-medis') }}">
                    <i class="fas fa-fw fa-file-medical"></i>
                    <span>Rekam Medis</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data & Laporan
            </div>

            <li class="nav-item {{ request()->routeIs('pasien.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pasien.index') }}">
                    <i class="fas fa-fw fa-hospital-user"></i>
                    <span>Database Pasien</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('antrian.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('antrian.index') }}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Laporan Kunjungan</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Akun
            </div>

            <li class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <i class="fas fa-fw fa-user-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" id="logout-sidebar-item">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex bg-info text-white mt-4">
                <p class="text-center mb-2"><strong>Jadwal Hari Ini</strong><br>
                <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('d M Y') }}</p>
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
                    
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari pasien..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Cari pasien..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @if($waitingCount > 0)
                                <span class="badge badge-danger badge-counter">{{ $waitingCount }}+</span>
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi
                                </h6>
                                @if($waitingCount > 0)
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('petugas.antrian') }}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-user-clock text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ now()->format('d M Y') }}</div>
                                        <span class="font-weight-bold">{{ $waitingCount }} pasien sedang menunggu</span>
                                    </div>
                                </a>
                                @else
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-check text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ now()->format('d M Y') }}</div>
                                        Tidak ada antrian yang menunggu
                                    </div>
                                </a>
                                @endif
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('petugas.antrian') }}">Tampilkan Semua Antrian</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
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
        
        document.getElementById('logout-sidebar-item').addEventListener('click', function(e) {
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
