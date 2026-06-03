<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(180deg, #cbe7ff 0%, #ffffff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #070d19;
            border-radius: 20px;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.2);
        }
        .login-left {
            padding: 50px;
            color: white;
        }
        .login-right {
            background: linear-gradient(135deg, #00d2ff 0%, #0066ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 50px;
        }
        
        /* CSS yang dimodifikasi untuk input form */
        .form-control-custom {
            background: transparent;
            border: none;
            border-bottom: 2px solid #34495e;
            border-radius: 0;
            color: #ffffff !important; /* Warna teks yang diketik jadi putih */
            padding-left: 0;
        }
        .form-control-custom::placeholder {
            color: #8fa0c0 !important; /* Warna teks placeholder dibuat sedikit lebih terang */
        }
        .form-control-custom:focus {
            background: transparent;
            border-color: #00d2ff;
            box-shadow: none;
            color: #ffffff !important;
        }
        
        .btn-login {
            background: linear-gradient(90deg, #00d2ff 0%, #0066ff 100%);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 25px;
            padding: 10px;
            width: 100%;
            transition: 0.3s;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="row login-card m-2">
            
            <div class="col-md-6 login-left">
                <h3 class="fw-bold mb-4">Login Admin</h3>
                
                <form action="proses_login_admin.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-light small">Username</label>
                        <input type="text" name="username" class="form-control form-control-custom" placeholder="Masukkan Username" required autocomplete="off">
                    </div>
                    <div class="mb-5">
                        <label class="form-label text-light small">Password</label>
                        <input type="password" name="password" class="form-control form-control-custom" placeholder="Masukkan Password" required>
                    </div>
                    <button type="submit" class="btn btn-login mb-3">Login</button>
                    <div class="text-center">
                        <a href="index.php" class="text-light small text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
                    </div>
                </form>
            </div>
            
            <div class="col-md-6 login-right d-none d-md-flex text-center">
                <div>
                    <h1 class="fw-bold tracking-wide">WELCOME<br>BACK!</h1>
                    <p class="small mt-2 text-white-50">AuLaundry Dashboard Management</p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>