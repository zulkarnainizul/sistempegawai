<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Pegawai SMKN 2 Pekanbaru</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background-color: #f4f7f9;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      background-repeat: no-repeat;
      background-position: center;
      background-size: 300px;
      background-attachment: fixed;
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.97);
      padding: 2.5rem;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 2;
    }

    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-header img {
      width: 75px;
      margin-bottom: 1rem;
    }

    .login-header h2 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 600;
      color: #2c3e50;
    }

    .login-header p {
      margin: 4px 0 0;
      font-size: 0.95rem;
      color: #7f8c8d;
    }

    .input-group {
      position: relative;
      margin-bottom: 1.3rem;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px;
      border: 1.8px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
      transition: 0.3s;
    }

    .input-group input:focus {
      border-color: #27ae60;
      box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
    }

    .input-group .icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
      cursor: pointer;
      transition: 0.3s;
    }

    .input-group .icon:hover {
      color: #27ae60;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background-color: #27ae60;
      border: none;
      border-radius: 6px;
      color: white;
      font-size: 1rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #2ecc71;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
    }

    .text-danger {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }

    .alert {
      padding: 0.8rem 1rem;
      border-radius: 6px;
      margin-bottom: 1.5rem;
      font-weight: 500;
    }

    .alert-danger {
      background-color: #fdecea;
      border: 1px solid #f5c2c7;
      color: #842029;
    }

    @media (max-width: 480px) {
      body {
        background-size: 200px;
      }
      .login-container {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="<?= base_url('assets/template/dist/img/logosmk.png') ?>" alt="Logo SMK">
            <h2>Sistem Pegawai</h2>
            <p>SMKN 2 Pekanbaru</p>
        </div>

        <?= $this->session->flashdata('pesan'); ?>

        <form action="<?= base_url('Login/autentikasi') ?>" method="post">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                <i class="icon fas fa-user"></i>
            </div>
            <?= form_error('username', '<div class="text-danger" style="margin-top:-15px; margin-bottom:15px;">', '</div>'); ?>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password">
                <i class="icon fas fa-eye" id="togglePassword"></i>
            </div>  
             <?= form_error('password', '<div class="text-danger" style="margin-top:-15px; margin-bottom:15px;">', '</div>'); ?>

            <button type="submit" class="btn-login">MASUK</button>
        </form>
    </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#togglePassword').click(function () {
        const password = $('#password');
        const type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
      });
    });
  </script>
</body>
</html>
