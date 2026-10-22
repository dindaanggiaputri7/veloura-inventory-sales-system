
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email | Veloura</title>

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
            max-width: 440px;
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

        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            margin-bottom: 24px;
            color: var(--wine);
            background: #f6eae7;
            border: 1px solid #efdfd9;
            border-radius: 17px;
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
            margin: 0 0 12px;
            color: var(--text);
            font-size: 27px;
            font-weight: 750;
            letter-spacing: -.6px;
        }

        .intro {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
        }

        .notice {
            padding: 13px 15px;
            margin-bottom: 20px;
            color: #73545d;
            background: #faf2ef;
            border: 1px solid #efdfd9;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.8;
        }

        .success {
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

        .secondary-button {
            color: var(--wine);
            background: #fff;
            border: 1px solid var(--border);
        }

        .secondary-button:hover {
            color: white;
            background: var(--wine);
            border-color: var(--wine);
        }

        .actions {
            display: grid;
            gap: 12px;
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
            <div class="icon-circle" aria-hidden="true">
                <svg width="29" height="29"
                     viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                    <path d="m4 7 8 6 8-6"/>
                </svg>
            </div>

            <div class="eyebrow">Account verification</div>

            <h1>Verifikasi email kamu</h1>

            <p class="intro">
                Terima kasih sudah bergabung dengan Veloura.
                Sebelum melanjutkan, pastikan alamat email akun kamu
                sudah terverifikasi.
            </p>

            <div class="notice">
                Jika kamu belum menerima email verifikasi, tekan tombol
                di bawah untuk meminta pengiriman ulang.
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="success" role="status">
                    Tautan verifikasi baru telah diminta. Periksa email kamu
                    jika pengiriman email sudah dikonfigurasi.
                </div>
            @endif

            @if ($errors->any())
                <div class="error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button class="button" type="submit">
                        Kirim Ulang Email Verifikasi
                        <span aria-hidden="true">→</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="button secondary-button" type="submit">
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </section>

        <div class="footer">
            © {{ date('Y') }} <strong>Veloura</strong><br>
            Inventory &amp; Sales Management System
        </div>

    </div>
</main>
</body>
</html>
