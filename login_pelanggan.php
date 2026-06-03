<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan - AuLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f9f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            background: linear-gradient(135deg, #007bff, #00d2ff); /* Tema biru cerah untuk pelanggan */
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .login-body {
            padding: 40px 30px;
            background-color: white;
        }
        .btn-custom {
            background: linear-gradient(135deg, #007bff, #00d2ff);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            padding: 12px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
            color: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: transparent;
            border-right: none;
            color: #007bff;
        }
        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <i class="fa-solid fa-shirt fa-3x mb-3"></i>
            <h3 class="fw-bold mb-0">Portal Pelanggan</h3>
            <p class="mb-0 text-white-50">Sistem AuLaundry</p>
        </div>
        <div class="login-body">
            
            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger text-center small rounded-3'>Username atau Password salah!</div>";
                }
            }
            ?>

            <form action="proses_login_pelanggan.php" method="POST">
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">USERNAME</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="username" class="form-control with-icon" placeholder="Masukkan username" required autocomplete="off">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control with-icon" placeholder="Masukkan password" required>
                    </div>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom"><i class="fa-solid fa-right-to-bracket me-2"></i> MASUK</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none text-muted small"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>