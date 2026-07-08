<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi KKM</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
            margin: 0;
            overflow-x: hidden;
        }

        .login-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ================= KIRI (55%) ================= */
        .login-left {
            width: 55%;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 50%, #1E3A8A 100%);
            padding: 4rem 5rem;
            position: relative;
            overflow: hidden;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Ambient Shapes */
        .login-left::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 70%;
            height: 70%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .illustration {
            animation: floating 3s ease-in-out infinite;
            max-width: 100%;
            height: auto;
            margin-bottom: 2rem;
            display: block;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .brand-title {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 1.15rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.85);
            max-width: 80%;
            margin-bottom: 2.5rem;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-weight: 400;
        }

        .feature-list i {
            color: #60A5FA;
            font-size: 1.4rem;
            margin-right: 1rem;
        }

        /* ================= KANAN (45%) ================= */
        .login-right {
            width: 45%;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }

        .login-form-container {
            width: 100%;
            max-width: 420px;
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-box {
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563EB;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .welcome-heading {
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }

        .welcome-subheading {
            color: #64748B;
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #334155;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input-group {
            border-radius: 12px;
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            transition: all 0.3s ease;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01);
            overflow: hidden;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #94A3B8;
            padding-left: 1.25rem;
        }

        .form-control {
            border: none;
            background: transparent;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: #0F172A;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: transparent;
        }

        .input-group:focus-within {
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            background-color: #ffffff;
        }

        .input-group:focus-within .input-group-text {
            color: #2563EB;
        }

        .input-group.is-invalid {
            border-color: #EF4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .input-group.is-invalid .input-group-text {
            color: #EF4444;
        }

        .form-check-input {
            border-radius: 6px;
            border-color: #CBD5E1;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #2563EB;
            border-color: #2563EB;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
        }

        .auth-link {
            color: #2563EB;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: #1E3A8A;
        }

        .btn-primary {
            background-color: #2563EB;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1D4ED8;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.35);
        }

        .admin-contact {
            text-align: center;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E2E8F0;
            color: #94A3B8;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .login-left {
                display: none !important;
            }
            .login-right {
                width: 100%;
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-layout">

        <!-- Bagian Kiri (55%) -->
        <div class="login-left d-none d-lg-flex">
            <div class="left-content">

                <!-- SVG Illustration -->
                <svg class="illustration" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 250" width="350" height="250">
                    <!-- Phone Body -->
                    <rect x="120" y="20" width="100" height="200" rx="15" fill="#ffffff" opacity="0.15" stroke="#ffffff" stroke-width="3"/>
                    <rect x="128" y="32" width="84" height="176" rx="8" fill="#ffffff" opacity="0.25"/>

                    <!-- QR Code Area inside Phone -->
                    <rect x="145" y="80" width="50" height="50" rx="4" fill="#ffffff"/>
                    <rect x="150" y="85" width="12" height="12" rx="2" fill="#1D4ED8"/>
                    <rect x="178" y="85" width="12" height="12" rx="2" fill="#1D4ED8"/>
                    <rect x="150" y="113" width="12" height="12" rx="2" fill="#1D4ED8"/>
                    <rect x="178" y="113" width="12" height="12" rx="2" fill="#1D4ED8"/>
                    <rect x="166" y="99" width="10" height="10" rx="2" fill="#1D4ED8"/>

                    <!-- Scanner Laser Line -->
                    <line x1="135" y1="105" x2="205" y2="105" stroke="#60A5FA" stroke-width="3" stroke-linecap="round">
                        <animate attributeName="y1" values="70;140;70" dur="2s" repeatCount="indefinite" />
                        <animate attributeName="y2" values="70;140;70" dur="2s" repeatCount="indefinite" />
                    </line>

                    <!-- Floating Bubbles / Decorative -->
                    <circle cx="50" cy="60" r="12" fill="#60A5FA" opacity="0.6">
                        <animate attributeName="cy" values="60;45;60" dur="3s" repeatCount="indefinite" />
                    </circle>
                    <circle cx="280" cy="150" r="20" fill="#93C5FD" opacity="0.4">
                        <animate attributeName="cy" values="150;130;150" dur="4s" repeatCount="indefinite" />
                    </circle>
                    <circle cx="80" cy="180" r="8" fill="#BFDBFE" opacity="0.5">
                        <animate attributeName="cy" values="180;165;180" dur="2.5s" repeatCount="indefinite" />
                    </circle>

                    <!-- Dashboard Card -->
                    <rect x="200" y="60" width="120" height="60" rx="10" fill="#ffffff" opacity="0.9" />
                    <rect x="215" y="75" width="40" height="8" rx="4" fill="#3B82F6" />
                    <rect x="215" y="95" width="90" height="6" rx="3" fill="#E2E8F0" />
                    <circle cx="300" cy="79" r="10" fill="#10B981" />
                    <path d="M296 79l3 3l5 -5" stroke="#ffffff" stroke-width="2" fill="none"/>
                </svg>

                <h1 class="brand-title">Sistem Absensi KKM</h1>
                <p class="brand-subtitle">Sistem absensi berbasis QR Code yang cepat, aman, dan mudah digunakan.</p>

                <ul class="feature-list">
                    <li><i class="bi bi-check-circle-fill"></i> Scan QR Code</li>
                    <li><i class="bi bi-check-circle-fill"></i> Rekap Absensi</li>
                    <li><i class="bi bi-check-circle-fill"></i> Export Excel</li>
                </ul>
            </div>
        </div>

        <!-- Bagian Kanan (45%) -->
        <div class="login-right">
            <div class="login-form-container">

                <!-- Logo & Heading -->
                <div class="d-flex align-items-center mb-4">
                    <div class="logo-box me-3">
                        <i class="bi bi-upc-scan fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Absensi KKM</h4>
                    </div>
                </div>

                <h2 class="welcome-heading">Selamat Datang</h2>
                <p class="welcome-subheading">Silakan login menggunakan akun yang telah diberikan oleh Administrator.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4 border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4 border-0 shadow-sm py-2" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group {{ $errors->has('email') ? 'is-invalid' : '' }}">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email Anda">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group {{ $errors->has('password') ? 'is-invalid' : '' }}">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input 
    id="password" 
    type="password" 
    class="form-control" 
    name="password" 
    required 
    autocomplete="current-password" 
    placeholder="Masukkan password Anda">

<span class="input-group-text" 
      id="togglePassword"
      style="cursor:pointer;">
    <i class="bi bi-eye" id="eyeIcon"></i>
</span>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                Remember Me
                            </label>
                        </div>

                        <a class="auth-link" href="{{ route('password.request') }}">
    Lupa Password?
</a>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center">
                            Login <i class="bi bi-arrow-right-short fs-5 ms-1"></i>
                        </button>
                    </div>

                    <!-- Removed Register Link -->

                    <!-- Admin Contact Info -->
                    <div class="admin-contact">
                        <i class="bi bi-info-circle me-1"></i> Hubungi Administrator apabila Anda belum memiliki akun.
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

togglePassword.addEventListener('click', function () {

    if (password.type === 'password') {

        password.type = 'text';

        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');

    } else {

        password.type = 'password';

        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }

});
</script>

</body>
</html>
