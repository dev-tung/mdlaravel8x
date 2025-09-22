<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập | Admin</title>

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('css/libraries/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}" />

</head>
<body class="hold-transition login-page">
    <div class="login-header">
        <img src="{{asset('img/shared/logo-white-transperent.png')}}" width="150" alt="Manh Dung Logo" class="Login-Logo" />
    </div>

    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <h4 class="login-box-msg">Đăng nhập vào hệ thống</h4>

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

                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/admin/shared/App.js') }}"></script>
</body>
</html>
