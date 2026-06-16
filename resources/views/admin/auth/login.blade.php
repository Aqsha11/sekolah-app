<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SMP 1 Lambandia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #0f172a 0%, #1e293b 55%, #334155 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('{{ asset('images/bg-school.jpg') }}') center/cover no-repeat;
            opacity: .18;
        }

        .login-left-content {
            position: relative;
            text-align: center;
            color: #fff;
            padding: 40px;
        }

        .school-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 2px solid rgba(255, 255, 255, .3);
            font-size: 36px;
            font-weight: 800;
            color: #0d6cf083;
        }

        .school-name {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .school-tagline {
            font-size: 13px;
            opacity: .75;
            line-height: 1.6;
            max-width: 280px;
            margin: 0 auto;
        }

        .login-right {
            width: 420px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }

        .login-greeting {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .login-sub {
            font-size: 13px;
            color: #6b7c9d;
            margin-bottom: 32px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }

        .form-control {
            border-radius: 8px;
            border: 1.5px solid #dde3f0;
            padding: 10px 14px;
            font-size: 13px;
            transition: border-color .2s;
        }

        .form-control:focus {
            border-color: #0d6cf083;
            box-shadow: 0 0 0 3px rgba(13, 108, 240, 0.18);
        }

        .input-group .input-group-text {
            border-radius: 0 8px 8px 0;
            border: 1.5px solid #dde3f0;
            border-left: none;
            background: #fff;
            cursor: pointer;
            color: #6b7c9d;
        }

        .input-group .input-group-text:hover {
            color: #0d6cf083;
        }

        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }

        .btn-login {
            width: 100%;
            background: #0f172a;
            color: #0d6cf0;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: #0d6cf083;
            color: #0f172a;
        }

        .form-check-label {
            font-size: 13px;
            color: #6b7c9d;
        }

        .link-forgot {
            font-size: 13px;
            color: #0d6cf083;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer {
            font-size: 11px;
            color: #b0b9cc;
            margin-top: 32px;
        }

        .alert {
            font-size: 13px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            .login-left {
                flex: none;
                padding: 40px 20px;
                min-height: 220px;
            }

            .login-left-content {
                padding: 0;
            }

            .school-name {
                font-size: 22px;
            }

            .school-logo {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .login-right {
                width: 100%;
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="login-left">
        <div class="login-left-content">
            <div class="school-logo"><i class="fa-solid fa-users"></i></div>
            <div class="school-name">SMP 1 LAMBANDIA</div>
            <p class="school-tagline">
                Mewujudkan generasi berkarakter, berprestasi dan berwawasan global.
            </p>
        </div>
    </div>

    <div class="login-right">
        <div style="width:100%">
            <div class="login-greeting">Selamat Datang 👋</div>
            <div class="login-sub">Silakan masuk untuk mengakses dashboard admin.</div>

            @if ($errors->any())
                <div class="alert alert-bg-red-600 mb-3">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success mb-3">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email"
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control"
                            placeholder="Masukkan password" required>
                        <span class="input-group-text" onclick="togglePass()">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk
                </button>
            </form>

            <div class="login-footer text-center">
                &copy; {{ date('Y') }} SMP 1 Lambandia. All rights reserved.
                <br>
                Powered by
                <a href="https://viteks.id" target="_blank"
                    style="color:#0dcaf0; font-weight:700; text-decoration:none;">
                    <img src="https://viteks.id/storage/site/J5MNxOhayYQO9ENI3oFOxy0fQd50ll84bFpyFshl.png"
                        style="height:11px; width:auto; display:inline-block; vertical-align:middle;" alt="VITEKS">
                    VITEKS
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const inp = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.className = 'fa-solid fa-eye-slash';
            } else {
                inp.type = 'password';
                icon.className = 'fa-solid fa-eye';
            }
        }
    </script>
</body>

</html>
