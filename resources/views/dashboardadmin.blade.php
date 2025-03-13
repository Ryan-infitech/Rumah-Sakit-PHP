@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <div>
            <span class="badge badge-primary p-2 mr-2">{{ now()->format('l, d F Y') }}</span>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Patients Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Datapasien::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Doctors Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Dokter</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Dokter::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Appointments Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Antrian Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ App\Models\Antrian::whereDate('tanggal_berobat', now()->format('Y-m-d'))->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Today's Queue -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Antrian Hari Ini</h6>
                    <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-right fa-sm"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasien</th>
                                    <th>Poliklinik</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $todayAppointments = App\Models\Antrian::whereDate('tanggal_berobat', now()->format('Y-m-d'))
                                    ->orderBy('no_antrian', 'asc')
                                    ->limit(5)
                                    ->get();
                                @endphp

                                @forelse($todayAppointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->no_antrian }}</td>
                                    <td>{{ $appointment->nama_pasien }}</td>
                                    <td>{{ $appointment->poliklinik }}</td>
                                    <td>{{ $appointment->nama_dokter }}</td>
                                    <td>
                                        @if($appointment->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($appointment->status == 'diproses')
                                            <span class="badge badge-info">Diproses</span>
                                        @elseif($appointment->status == 'dilayani')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $appointment->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada antrian hari ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- System Health Monitoring -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pemantauan Sistem</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Interval:</div>
                            <a class="dropdown-item active" href="#" data-interval="5">5 detik</a>
                            <a class="dropdown-item" href="#" data-interval="10">10 detik</a>
                            <a class="dropdown-item" href="#" data-interval="30">30 detik</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" id="refreshStats"><i class="fas fa-sync-alt fa-sm fa-fw mr-2 text-gray-400"></i>Refresh Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-left-primary h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                CPU Usage</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="cpuLoadDisplay">0%</div>
                                            <div class="sparkline-container mt-2">
                                                <canvas id="cpuSparkline" height="30"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-microchip fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-left-success h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Memory Usage</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="memoryUsageDisplay">0 MB</div>
                                            <div class="sparkline-container mt-2">
                                                <canvas id="memorySparkline" height="30"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-memory fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="card border-left-info h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                DB Queries</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="dbQueriesDisplay">0</div>
                                            <div class="sparkline-container mt-2">
                                                <canvas id="dbQueriesSparkline" height="30"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-database fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Active Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeUsersDisplay">0</div>
                                            <div class="sparkline-container mt-2">
                                                <canvas id="activeUsersSparkline" height="30"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Information Card in Right Column -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered m-0">
                                    <tbody id="systemMetricsBody">
                                        <tr>
                                            <td><i class="fas fa-server fa-fw text-primary mr-1"></i> Waktu Uptime Server</td>
                                            <td id="serverUptime">Loading...</td>
                                            <td><span class="badge badge-success">Normal</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plug fa-fw text-info mr-1"></i> Database Connections</td>
                                            <td id="dbConnections">Loading...</td>
                                            <td id="dbConnectionStatus"><span class="badge badge-success">Normal</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-code fa-fw text-success mr-1"></i> PHP Version</td>
                                            <td>{{ phpversion() }}</td>
                                            <td><span class="badge badge-success">Compatible</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-laptop-code fa-fw text-warning mr-1"></i> Laravel Version</td>
                                            <td>{{ app()->version() }}</td>
                                            <td><span class="badge badge-success">Supported</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Access & System Info -->
        <div class="col-xl-4 col-lg-5">
            <!-- Quick Access Cards -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Akses Cepat</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-plus"></i>
                        </span>
                        <span class="text">Tambah User</span>
                    </a>
                    <a href="{{ route('dokter.create') }}" class="btn btn-success btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-user-md"></i>
                        </span>
                        <span class="text">Tambah Dokter</span>
                    </a>
                    <a href="{{ route('poliklinik.create') }}" class="btn btn-info btn-icon-split btn-block mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-clinic-medical"></i>
                        </span>
                        <span class="text">Tambah Poliklinik</span>
                    </a>
                    <a href="{{ route('jadwalpoliklinik.create') }}" class="btn btn-secondary btn-icon-split btn-block">
                        <span class="icon text-white-50">
                            <i class="fas fa-calendar-plus"></i>
                        </span>
                        <span class="text">Atur Jadwal</span>
                    </a>
                </div>
            </div>

            <!-- System Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 8rem;" 
                            src="{{ asset('https://cdnl.iconscout.com/lottie/premium/thumb/hospital-building-animation-download-in-lottie-json-gif-static-svg-file-formats--patient-room-emergency-office-medical-and-healthy-pack-healthcare-animations-4709608.gif') }}" alt="Hospital Logo" width="150%">
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Jam Sistem:</span> 
                        <span id="time">{{ now()->format('H:i:s') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Status Server:</span> 
                        <span class="badge badge-success" id="serverStatus">Online</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">CPU Load:</span> 
                        <span id="cpuLoad">Loading...</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Memory Usage:</span> 
                        <span id="memoryUsage">Loading...</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Versi Aplikasi:</span> 1.0.0
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Pengguna Login:</span> {{ Auth::user()->nama_user }}
                    </div>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pengguna Aktif</h6>
                    <span class="badge badge-success" id="activeUsersCounter">0 online</span>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="font-weight-bold">Total Sessions:</span> 
                        <span id="totalSessions">Loading...</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-weight-bold">Pengguna Online:</span> 
                        <span id="onlineUsers">Loading...</span>
                        <span class="badge badge-info ml-1">dari total <span id="totalUsers">0</span> pengguna</span>
                    </div>
                    <div class="small mt-3">Update terakhir: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span></div>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" id="activeUsersTable">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="activeUsersList">
                                    <tr>
                                        <td colspan="3" class="text-center">Loading user data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#cpuLoad').text('Loading...');
        $('#memoryUsage').text('Loading...');
        // Update clock every second
        setInterval(function() {
            var date = new Date();
            var time = date.toLocaleTimeString('id-ID');
            $('#time').text(time);
        }, 1000);

        // Use a custom DataTable for this page
        $('#dataTable').DataTable({
            "destroy": true,
            "paging": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "responsive": true
        });

        // Initialize sparkline charts
        const cpuSparklineCtx = document.getElementById('cpuSparkline').getContext('2d');
        const memorySparklineCtx = document.getElementById('memorySparkline').getContext('2d');
        const dbQueriesSparklineCtx = document.getElementById('dbQueriesSparkline').getContext('2d');
        const activeUsersSparklineCtx = document.getElementById('activeUsersSparkline').getContext('2d');

        // Sparkline data (smaller datasets for the info cards)
        const cpuSparklineData = {
            labels: Array(6).fill(''),
            datasets: [{
                label: 'CPU',
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4,
                fill: true,
                data: Array(6).fill(0)
            }]
        };

        const memorySparklineData = {
            labels: Array(6).fill(''),
            datasets: [{
                label: 'Memory',
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4,
                fill: true,
                data: Array(6).fill(0)
            }]
        };

        const dbQueriesSparklineData = {
            labels: Array(6).fill(''),
            datasets: [{
                label: 'Queries',
                borderColor: '#36b9cc',
                backgroundColor: 'rgba(54, 185, 204, 0.1)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4,
                fill: true,
                data: Array(6).fill(0)
            }]
        };

        const activeUsersSparklineData = {
            labels: Array(6).fill(''),
            datasets: [{
                label: 'Users',
                borderColor: '#f6c23e',
                backgroundColor: 'rgba(246, 194, 62, 0.1)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4,
                fill: true,
                data: Array(6).fill(0)
            }]
        };

        // Sparkline options
        const sparklineOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: false
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false,
                    beginAtZero: true
                }
            },
            animation: {
                duration: 0
            }
        };

        // Create sparkline charts
        const cpuSparkline = new Chart(cpuSparklineCtx, {
            type: 'line',
            data: cpuSparklineData,
            options: sparklineOptions
        });

        const memorySparkline = new Chart(memorySparklineCtx, {
            type: 'line',
            data: memorySparklineData,
            options: sparklineOptions
        });

        const dbQueriesSparkline = new Chart(dbQueriesSparklineCtx, {
            type: 'line',
            data: dbQueriesSparklineData,
            options: sparklineOptions
        });

        const activeUsersSparkline = new Chart(activeUsersSparklineCtx, {
            type: 'line',
            data: activeUsersSparklineData,
            options: sparklineOptions
        });

        // Update interval in seconds
        let updateInterval = 5;
        
        // Function to update active users list
        function updateActiveUsersList(users) {
            const usersList = $('#activeUsersList');
            usersList.empty();
            
            if (users && users.length > 0) {
                users.forEach(user => {
                    usersList.append(`
                        <tr>
                            <td>${user.name}</td>
                            <td><span class="badge badge-primary">${user.role}</span></td>
                            <td><span class="badge badge-success">Online</span></td>
                        </tr>
                    `);
                });
                
                // Update counter with accurate number
                $('#activeUsersCounter').text(users.length + ' online');
            } else {
                usersList.append(`
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada pengguna aktif saat ini
                        </td>
                    </tr>
                `);
                
                // Update counter to zero
                $('#activeUsersCounter').text('0 online');
            }
        }
        
        // Function to fetch system metrics
        function fetchSystemMetrics() {
            $.ajax({
                url: '{{ route("admin.system-metrics") }}',
                method: 'GET',
                success: function(response) {
                    console.log('Received metrics:', response);
                    
                    // Update sparkline charts
                    addDataToSparkline(cpuSparkline, response.cpu_usage);
                    addDataToSparkline(memorySparkline, response.memory_usage);
                    addDataToSparkline(dbQueriesSparkline, response.db_queries);
                    addDataToSparkline(activeUsersSparkline, response.active_users);
                    
                    // Update metrics display with trend indicators
                    updateMetricDisplay('cpuLoadDisplay', response.cpu_usage, '%', getCpuStatusClass(response.cpu_usage));
                    updateMetricDisplay('memoryUsageDisplay', response.memory_usage, ' MB', getMemoryStatusClass(response.memory_usage));
                    updateMetricDisplay('dbQueriesDisplay', response.db_queries, '', getDbQueriesStatusClass(response.db_queries));
                    updateMetricDisplay('activeUsersDisplay', response.active_users, '', null);
                    
                    // Update metrics in system info section
                    $('#cpuLoad').text(response.cpu_usage + '%');
                    $('#memoryUsage').text(response.memory_usage + ' MB');
                    $('#serverUptime').text(response.uptime);
                    $('#dbConnections').text(response.db_connections);
                    $('#totalSessions').text(response.total_sessions);
                    $('#onlineUsers').text(response.active_users);
                    $('#totalUsers').text(response.total_users);
                    $('#lastUpdate').text(new Date().toLocaleTimeString('id-ID'));
                    
                    // Update DB connection status
                    updateDbConnectionStatus(response.db_connections);
                    
                    // Update active users list with the accurate data
                    updateActiveUsersList(response.active_user_details);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching metrics:', status, error);
                    console.error('Response:', xhr.responseText);
                    $('#serverStatus').removeClass('badge-success').addClass('badge-danger').text('Error');
                    console.log('Fetching metrics from:', '{{ route("admin.system-metrics") }}');
                }
            });
        }
        
        // Function to determine CPU status class
        function getCpuStatusClass(cpuUsage) {
            if (cpuUsage >= 80) return 'danger';
            if (cpuUsage >= 60) return 'warning';
            return 'success';
        }
        
        // Function to determine Memory status class
        function getMemoryStatusClass(memoryUsage) {
            if (memoryUsage >= 400) return 'danger';
            if (memoryUsage >= 300) return 'warning';
            return 'success';
        }
        
        // Function to determine DB Queries status class
        function getDbQueriesStatusClass(queries) {
            if (queries >= 20) return 'danger';
            if (queries >= 15) return 'warning';
            return 'success';
        }
        
        // Function to update metric display with trend indicator
        function updateMetricDisplay(elementId, value, unit, statusClass) {
            const element = $(`#${elementId}`);
            let html = value + unit;
            
            if (statusClass) {
                html += ` <i class="fas fa-circle text-${statusClass} fa-sm"></i>`;
            }
            
            element.html(html);
        }
        
        // Function to update DB connection status
        function updateDbConnectionStatus(connections) {
            const status = $('#dbConnectionStatus');
            if (connections > 10) {
                status.html('<span class="badge badge-warning">High</span>');
            } else if (connections > 20) {
                status.html('<span class="badge badge-danger">Critical</span>');
            } else {
                status.html('<span class="badge badge-success">Normal</span>');
            }
        }
        
        // Function to add data to sparkline chart
        function addDataToSparkline(chart, newData) {
            chart.data.datasets[0].data.shift();
            chart.data.datasets[0].data.push(newData);
            chart.update();
        }
        
        // Set interval for updating metrics
        let metricsInterval = setInterval(fetchSystemMetrics, updateInterval * 1000);
        
        // Initially fetch system metrics
        fetchSystemMetrics();
        
        // Handle interval change
        $('.dropdown-item[data-interval]').on('click', function(e) {
            e.preventDefault();
            
            // Update active state
            $('.dropdown-item[data-interval]').removeClass('active');
            $(this).addClass('active');
            
            // Update interval
            updateInterval = parseInt($(this).data('interval'));
            
            // Clear and set new interval
            clearInterval(metricsInterval);
            metricsInterval = setInterval(fetchSystemMetrics, updateInterval * 1000);
        });
        
        // Handle refresh button
        $('#refreshStats').on('click', function(e) {
            e.preventDefault();
            fetchSystemMetrics();
        });
    });
</script>

<style>
    .chart-card {
        background-color: #fff;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .chart-title {
        font-size: 0.8rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 8px;
        color: #4e73df;
    }
    
    .chart-container {
        background-color: #f8f9fc;
        border-radius: 4px;
        padding: 8px;
    }
    
    .sparkline-container {
        height: 30px;
        width: 100%;
        position: relative;
    }
    
    /* Add a glow effect to metric cards on hover */
    .card.border-left-primary:hover,
    .card.border-left-success:hover,
    .card.border-left-info:hover,
    .card.border-left-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.15);
        transition: all 0.3s ease;
    }
    
    /* Status indicators */
    .text-danger {
        color: #e74a3b !important;
    }
    
    .text-warning {
        color: #f6c23e !important;
    }
    
    .text-success {
        color: #1cc88a !important;
    }
</style>
@endpush