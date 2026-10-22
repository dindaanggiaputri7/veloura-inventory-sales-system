
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Veloura</title>

    <style>
        :root {
            --wine: #5b2632;
            --wine-dark: #431b25;
            --cream: #faf6f2;
            --text: #39242a;
            --muted: #8c7b80;
            --border: #eaded9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(ellipse at 10% 10%, #f0e2dc 0%, transparent 36%),
                radial-gradient(ellipse at 95% 95%, #f3e7e3 0%, transparent 32%),
                var(--cream);
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* LOGO */

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 13px;
            margin-bottom: 29px;
        }

        .brand-symbol {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 49px;
            height: 49px;
            color: white;
            background: var(--wine);
            border-radius: 14px;
            font-family: Georgia, serif;
            font-size: 29px;
            font-weight: bold;
            box-shadow: 0 6px 15px rgba(91,38,50,.13);
        }

        .brand-name {
            color: var(--wine);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .brand-caption {
            margin-top: 5px;
            color: #927a81;
            font-size: 9px;
            letter-spacing: 1.3px;
        }

        /* LOGIN CARD */

        .login-card {
            padding: 35px;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(234,222,217,.95);
            border-radius: 19px;
            box-shadow: 0 18px 55px rgba(69,35,43,.075);
        }

        .eyebrow {
            margin-bottom: 11px;
            color: #a06c7a;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 10px;
            color: var(--text);
            font-size: 27px;
            font-weight: 750;
            letter-spacing: -.6px;
        }

        .intro {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .message {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
        }

        .message-success {
            color: #246b49;
            background: #edf8f1;
            border: 1px solid #d2ead9;
        }

        .message-error {
            color: #a52d3c;
            background: #fff1f0;
            border: 1px solid #f0d0ce;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #49363c;
            font-size: 12px;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input {
            width: 100%;
            height: 47px;
            padding: 0 14px;
            color: var(--text);
            background: #fffdfc;
            border: 1px solid var(--border);
            border-radius: 9px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input::placeholder {
            color: #b2a2a6;
        }

        .input:focus {
            border-color: var(--wine);
            box-shadow: 0 0 0 3px rgba(91,38,50,.08);
        }

        .password-input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            color: #927b82;
            background: transparent;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .toggle-password:hover {
            color: var(--wine);
            background: #f6eeeb;
        }

        .field-error {
            margin-top: 7px;
            color: #b02d3d;
            font-size: 11px;
        }

        .options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin: 2px 0 24px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #76666c;
            font-size: 12px;
            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: var(--wine);
        }

        .forgot {
            color: var(--wine);
            font-size: 12px;
            font-weight: 650;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .login-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 47px;
            padding: 12px;
            color: white;
            background: var(--wine);
            border: 1px solid var(--wine);
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 750;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .login-button:hover {
            background: var(--wine-dark);
            transform: translateY(-1px);
        }

        .login-button:focus-visible,
        .toggle-password:focus-visible {
            outline: 3px solid #cba1ac;
            outline-offset: 3px;
        }

        .footer {
            margin-top: 23px;
            color: #9a898e;
            font-size: 10px;
            line-height: 1.9;
            text-align: center;
        }

        .footer strong {
            color: var(--wine);
        }

        @media (max-width: 480px) {
            .page {
                padding: 24px 16px;
            }

            .login-card {
                padding: 27px 22px;
                border-radius: 16px;
            }

            .brand {
                margin-bottom: 23px;
            }

            .brand-symbol {
                width: 44px;
                height: 44px;
                font-size: 26px;
            }

            .brand-name {
                font-size: 21px;
            }

            h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>
<main class="page">
    <div class="login-wrapper">

        <div class="brand">
            <div class="brand-symbol">V</div>
            <div>
                <div class="brand-name">VELOURA</div>
                <div class="brand-caption">INVENTORY &amp; SALES MANAGEMENT</div>
            </div>
        </div>

        <section class="login-card">
            <div class="eyebrow">Welcome back</div>

            <h1>Selamat datang!</h1>

            <p class="intro">
                Masuk ke akun kamu untuk melanjutkan aktivitas di Veloura.
            </p>

            @if (session('status'))
                <div class="message message-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="message message-error" role="alert">
                    <strong>Login belum berhasil.</strong><br>
                    Periksa kembali email dan password kamu.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email">Alamat Email</label>

                    <input
                        class="input"
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="username"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input
                            class="input password-input"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            class="toggle-password"
                            type="button"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                            aria-pressed="false"
                        >
                            <svg id="eyeIcon" width="19" height="19"
                                 viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round"
                                 aria-hidden="true">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="options">
                    <label class="remember" for="remember_me">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                        >
                        <span>Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button class="login-button" type="submit">
                    Masuk ke akun <span aria-hidden="true">→</span>
                </button>
            </form>
        </section>

        <div class="footer">
            © {{ date('Y') }} <strong>Veloura</strong><br>
            Inventory &amp; Sales Management System
        </div>

    </div>
</main>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const show = passwordInput.type === 'password';

        passwordInput.type = show ? 'text' : 'password';

        togglePassword.setAttribute(
            'aria-label',
            show ? 'Sembunyikan password' : 'Tampilkan password'
        );

        togglePassword.setAttribute('aria-pressed', String(show));

        eyeIcon.innerHTML = show
            ? '<path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.5 0 10 7 10 7a15 15 0 0 1-4 4.8"/><path d="M6.2 6.2C3.5 8 2 12 2 12s3.5 7 10 7c1.3 0 2.5-.3 3.5-.8"/>'
            : '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>';
    });
</script>
</body>
</html>
