<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPAYU SPP System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(135deg, #2563EB 0%, #1E293B 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-left {
            background: linear-gradient(135deg, #2563EB, #1E293B);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right { padding: 40px; }
        .btn-login {
            background: #2563EB;
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover { 
            background: #1d4ed8; 
            transform: translateY(-2px);
        }
        .form-control { 
            border-radius: 10px; 
            padding: 12px; 
        }
        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="login-card row g-0">
                    <div class="col-md-5 login-left text-center">
                        <i class="fas fa-graduation-cap fa-4x mb-3"></i>
                        <h3 class="mb-3">SIPAYU</h3>
                        <p class="mb-0">Sistem Pembayaran SPP Digital</p>
                        
                    </div>
                    <div class="col-md-7 login-right">
                        <h3 class="mb-4">Login ke Akun Anda</h3>
                        
                        <?php if(isset($errors) && $errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php echo $errors->first(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="/login">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Username / NIS</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="username" class="form-control" required autofocus>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-login w-100 text-white">Login</button>
                        </form>
                        <hr class="my-4">
                        <div class="text-center text-muted">
                            <small>Sistem Pembayaran SPP Online</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>