<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesion - Sistema Restaurante</title>

    <style>
        :root {
            --bg-a: #ecfeff;
            --bg-b: #f8fafc;
            --card: #ffffff;
            --line: #dbeafe;
            --brand: #0f766e;
            --brand-dark: #115e59;
            --text: #0f172a;
            --muted: #64748b;
            --error: #b91c1c;
        }

        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, var(--bg-a), var(--bg-b)); color: var(--text); }

        .login-card { width: min(420px, 92vw); background: var(--card); border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 18px 30px rgba(15, 23, 42, 0.12); padding: 22px; }
        .title { margin: 0; font-size: 24px; }
        .subtitle { margin: 6px 0 20px; color: var(--muted); font-size: 14px; }

        .field { display: grid; gap: 6px; margin-bottom: 12px; }
        .field label { font-size: 14px; font-weight: 600; }
        .input { width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 12px; font-size: 14px; }

        .btn { width: 100%; border: none; border-radius: 10px; background: var(--brand); color: #fff; font-size: 14px; padding: 10px 12px; cursor: pointer; margin-top: 8px; }
        .btn:hover { background: var(--brand-dark); }

        .alert { border-radius: 10px; padding: 10px 12px; margin-bottom: 12px; font-size: 14px; }
        .alert-error { background: #fee2e2; color: var(--error); border: 1px solid #fca5a5; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .error-list { margin: 8px 0 0; padding-left: 18px; }
    </style>
</head>
<body>
    <section class="login-card">
        <h1 class="title">Sistema Restaurante</h1>
        <p class="subtitle">Acceso de administracion</p>

        <x-flash-messages />

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="field">
                <label for="email">Correo</label>
                <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Contrasena</label>
                <input class="input" type="password" id="password" name="password" required>
            </div>

            <button class="btn" type="submit">Entrar</button>
        </form>
    </section>
</body>
</html>
