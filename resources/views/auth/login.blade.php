<!-- login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Rumah Sakit</title>
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
        .btn-info {
            background-color: #2caec8;
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-info:hover {
            background-color: #1d8f98;
        }
        .alert {
            margin-bottom: 20px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
        <img src="https://cdnl.iconscout.com/lottie/premium/thumb/hospital-building-animation-download-in-lottie-json-gif-static-svg-file-formats--patient-room-emergency-office-medical-and-healthy-pack-healthcare-animations-4709608.gif" alt="logo rumah sakit" width="50%">
        <br>
        Rumah Sakit <br>
        <div class="doctor-name">Dr. Rian </div>
        </div>

        <div class="card-body">
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

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Email/Username" required autofocus value="{{ old('username') }}">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group password-container">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <span class="password-toggle" id="toggle-icon" onclick="togglePassword()">
                        <i class="fa fa-eye"></i>
                    </span>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                        <label class="custom-control-label" for="remember">Remember Me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="#" class="btn btn-info">Forgot Password?</a>

                <div class="text-muted mt-3">
                    Belum punya akun? <a href="{{ route('register') }}">Register</a>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon").querySelector("i");
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

        // Initialize single document ready function
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                console.log('Login form submitted');
                // The form submission will proceed normally
            });
            
            // Handle success and error messages with Vanilla JS
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error') }}";
            
            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    confirmButtonText: 'OK'
                });
            }
            
            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
</body>
</html>
