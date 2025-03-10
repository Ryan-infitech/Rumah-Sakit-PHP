<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Rumah Sakit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-image: url('/rsaule.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .card-header {
            background-color: transparent;
            color: #4e73df;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .doctor-name {
            font-size: 18px;
            color: #6c757d;
            font-weight: normal;
            margin-top: 5px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 10px rgba(78, 115, 223, 0.4);
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 20px;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #375a7f;
        }
        .text-muted {
            text-align: center;
            display: block;
            margin-top: 20px;
            color: #858796;
        }
        .text-muted a {
            color: #4e73df;
            text-decoration: none;
        }
        .text-muted a:hover {
            text-decoration: underline;
        }
        .text-danger {
            color: #e74a3b;
            text-align: left;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
        <img src="https://cdnl.iconscout.com/lottie/premium/thumb/hospital-building-animation-download-in-lottie-json-gif-static-svg-file-formats--patient-room-emergency-office-medical-and-healthy-pack-healthcare-animations-4709608.gif" alt="logo rumah sakit" width="50%">
        <br>    
        Rumah Sakit <br>
            <div class="doctor-name">Dr. Rian</div>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registrationForm">
                @csrf
                <div class="form-group">
                    <input type="text" name="nama_user" id="nama" class="form-control" placeholder="Nama" value="{{ old('nama_user') }}" required>
                    <div class="text-danger" id="namaError">
                        @error('nama_user')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Email/Username" value="{{ old('username') }}" required>
                    <div class="text-danger" id="usernameError">
                        @error('username')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group password-container">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <span class="password-toggle" id="toggle-password" onclick="togglePassword()">
                        <i class="fa fa-eye"></i>
                    </span>
                    <div class="text-danger" id="passwordError">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group password-container">
                    <input type="password" name="password_confirmation" id="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password" required>
                    <span class="password-toggle" id="toggle-confirm-password" onclick="toggleConfirmPassword()">
                        <i class="fa fa-eye"></i>
                    </span>
                    <div class="text-danger" id="konfirmasiPasswordError"></div>
                </div>
                <div class="form-group">
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" placeholder="No Telepon" value="{{ old('no_telepon') }}" required>
                    <div class="text-danger" id="teleponError">
                        @error('no_telepon')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrasi</button>
            </form>
            
            <div class="text-muted mt-3">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-password").querySelector('i');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        function toggleConfirmPassword() {
            var confirmPasswordField = document.getElementById("konfirmasi_password");
            var toggleIcon = document.getElementById("toggle-confirm-password").querySelector('i');
            if (confirmPasswordField.type === "password") {
                confirmPasswordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                confirmPasswordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        // Let's try a different approach - using traditional form submission first with client-side validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset previous error messages
                document.querySelectorAll('.text-danger').forEach(el => {
                    el.textContent = '';
                });
                
                // Get form values
                const nama = document.getElementById('nama').value.trim();
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                const konfirmasiPassword = document.getElementById('konfirmasi_password').value;
                const noTelepon = document.getElementById('no_telepon').value.trim();
                
                // Validation flags
                let isValid = true;
                
                // Basic validation
                if (nama.length < 3) {
                    document.getElementById('namaError').textContent = 'Nama minimal 3 karakter';
                    isValid = false;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(username)) {
                    document.getElementById('usernameError').textContent = 'Format email tidak valid';
                    isValid = false;
                }
                
                if (password.length < 6) {
                    document.getElementById('passwordError').textContent = 'Password minimal 6 karakter';
                    isValid = false;
                }
                
                if (password !== konfirmasiPassword) {
                    document.getElementById('konfirmasiPasswordError').textContent = 'Konfirmasi password tidak cocok';
                    isValid = false;
                }
                
                const phoneRegex = /^[0-9]{10,13}$/;
                if (!phoneRegex.test(noTelepon)) {
                    document.getElementById('teleponError').textContent = 'Nomor telepon harus 10-13 digit angka';
                    isValid = false;
                }
                
                if (isValid) {
                    // Show loading state with SweetAlert
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form (traditional submission)
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>