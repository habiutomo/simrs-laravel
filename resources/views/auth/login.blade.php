<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMRS RS Ar Bunda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: #fff; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,.2); overflow: hidden; }
        .login-header { background: #0d6efd; color: #fff; padding: 30px; text-align: center; }
        .login-header h3 { font-weight: 700; margin: 0; }
        .login-body { padding: 30px; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(13,110,253,.15); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-hospital fa-3x mb-3"></i>
                        <h3>SIMRS RS Ar Bunda</h3>
                        <p class="mb-0 small opacity-75">Sistem Informasi Manajemen Rumah Sakit</p>
                    </div>
                    <div class="login-body">
                        @if($errors->any())
                            <div class="alert alert-danger py-2 small">{{ $errors->first('email') }}</div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@rsarbunda.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">MASUK</button>
                        </form>
                        <div class="text-center mt-3">
                            <small class="text-muted">Demo: admin@rsarbunda.com / password</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</body>
</html>