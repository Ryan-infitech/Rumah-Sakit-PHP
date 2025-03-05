<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background-color: #ffffff;
            none: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }
        .card-header {
            background-color: transparent;
            color: #5a5e69;
            font-size: 24px;
            text-align: center;
            border-bottom: none;
            margin-bottom: 20px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 40px;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 5px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #ffffff;
            margin-top: 10px;
        }
        .btn-primary:hover {
            background-color: #375a7f;
        }
        .text-muted {
            text-align: center;
            display: block;
            margin-top: 10px;
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
        <div class="card-header">Registrasi</div>
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
            
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama user">Nama</label>
                    <input type="text" name="nama user" id="nama user" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label for="username">Email/Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter Password Confirmation" required>
                </div>
                <div class="form-group">
                    <label for="no_telepon">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control" placeholder="Enter Phone Number" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrasi</button>
            </form>
            
            <div class="text-muted mt-3">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>

    <script>
        // Optional: Script untuk preview gambar
        document.getElementById('foto_user').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                if (output) {
                    output.src = reader.result;
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
</body>
</html>