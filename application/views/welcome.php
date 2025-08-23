<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - SIK SMKN 2 Pekanbaru</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>">
    
    <style>
    :root {
        /* Variabel warna diubah ke hijau */
        --primary-color: #27ae60;   /* Hijau Segar */
        --secondary-color: #229954; /* Hijau Lebih Gelap */
        --text-color: #f8f9fa;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        overflow: hidden; 
    }

    .welcome-hero {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: var(--text-color);
        position: relative;
        /* background-image: url('<?= base_url("assets/template/dist/img/Gedung_Sekolah.jpg") ?>'); */
        background-image: url('https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=2086&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
    }

    .welcome-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
    }

    .welcome-card {
        position: relative;
        width: 90%;
        max-width: 550px;
        padding: 3rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 var(--shadow-color);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .welcome-card > * {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .welcome-card .logo {
        width: 90px;
        height: auto;
        margin-bottom: 1.5rem;
        animation-delay: 0.2s;
    }

    .welcome-card h1 {
        font-weight: 700;
        font-size: 2.8rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px var(--shadow-color);
        animation-delay: 0.4s;
    }

    .welcome-card .lead {
        font-size: 1.25rem;
        font-weight: 300;
        margin-bottom: 2rem;
        text-shadow: 0 1px 3px var(--shadow-color);
        animation-delay: 0.6s;
    }
    
    .btn-welcome {
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 14px 30px;
        border-radius: 50px;
        color: white;
        /* Menggunakan gradien hijau dari variabel di atas */
        background-image: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border: none;
        /* Bayangan tombol diubah menjadi hijau */
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
        transition: all 0.3s ease;
        animation-delay: 0.8s;
    }

    .btn-welcome:hover, .btn-welcome:focus {
        color: white;
        transform: translateY(-3px) scale(1.05);
        /* Bayangan saat hover juga diubah menjadi hijau */
        box-shadow: 0 7px 20px rgba(39, 174, 96, 0.6);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>
<body class="welcome-hero">

    <div class="welcome-card">
        <img src="<?= base_url('assets/template/dist/img/logosmk.png') ?>" alt="Logo SMKN 2 Pekanbaru" class="logo">
        
        <h1>Selamat Datang</h1>
        
        <p class="lead">
            di <strong>Sistem Informasi Kepegawaian</strong> SMKN 2 Pekanbaru
        </p>

        <a href="<?= base_url('Login') ?>" class="btn btn-welcome">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Masuk ke Sistem
        </a>
    </div>

    <script src="<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>