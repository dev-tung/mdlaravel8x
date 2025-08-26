<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập | Admin</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('css/admin/adminlte.css') }}">
    <style>
        body {
            background: #f4f6f9;
        }
        .login-box {
            width: 400px;
        }
        .login-card-body {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .form-control {
            border-radius: 30px;
            padding-left: 40px; /* để icon không đè chữ */
        }
        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-primary {
            border-radius: 30px;
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>MD</b>SPORTS</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập để vào hệ thống</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="form-group position-relative mb-3">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" required autofocus>
                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group position-relative mb-3">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Mật khẩu" required>
                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember + Button -->
                <div class="row">
                    <div class="col-7">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ</label>
                        </div>
                    </div>
                    <div class="col-5">
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                </div>
            </form>

            <p class="mb-1 mt-3">
                <a href="#">Quên mật khẩu?</a>
            </p>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('js/shared/processing.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/admin/adminlte.min.js') }}"></script>
</body>
</html>
