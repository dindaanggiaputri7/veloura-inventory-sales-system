
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Veloura</title>

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

        .wrapper {
            width: 100%;
            max-width: 420px;
        }

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

        .card {
            padding: 35px;
            background: rgba(255,255,255,.95);
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
            margin: 0 0 25px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .status {
            padding: 12px 14px;
            margin-bottom: 18px;
            color: #246b49;
            background: #edf8f1;
            border: 1px solid #d2ead9;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
        }

        .error {
            padding: 12px 14px;
            margin-bottom: 18px;
            color: #a52d3c;
            background: #fff1f0;
            border: 1px solid #f0d0ce;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.7;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #49363c;
            font-size: 12px;
            font-weight: 700;
        }

        .input {
            display: block;
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

        .field-error {
            margin-top: 7px;
            color: #b02d3d;
            font-size: 11px;
        }

        .button {
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

        .button:hover {
            background: var(--wine-dark);
            transform: translateY(-1px);
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: var(--wine);
            font-size: 12px;
            font-weight: 650;
            text-align: center;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
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

            .card {
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
    <div class="wrapper">

        <div class="brand">
            <div class="brand-symbol">V</div>
            <div>
                <div class="brand-name">VELOURA</div>
                <div class="brand-caption">INVENTORY &amp; SALES MANAGEMENT</div>
            </div>
        </div>

        <section class="card">
            <div class="eyebrow">Account recovery</div>

            <h1>Lupa password?</h1>

            <p class="intro">
                Tidak perlu khawatir. Masukkan alamat email akun kamu,
                dan kami akan mengirimkan tautan untuk mengatur ulang password.
            </p>

            @if (session('status'))
                <div class="status" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error" role="alert">
                    Periksa kembali alamat email yang kamu masukkan.
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                        autocomplete="email"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button class="button" type="submit">
                    Kirim Tautan Reset Password
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <a class="back-link" href="{{ route('login') }}">
                ← Kembali ke halaman login
            </a>
        </section>

        <div class="footer">
            © {{ date('Y') }} <strong>Veloura</strong><br>
            Inventory &amp; Sales Management System
        </div>

    </div>
</main>
</body>
</html>
