<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') - Sistema Restaurante</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg: #f3f4f6;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --line: #e5e7eb;
            --brand: #0f766e;
            --brand-dark: #115e59;
            --danger: #b91c1c;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --error-bg: #fee2e2;
            --error-text: #991b1b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background: radial-gradient(circle at top left, #d1fae5, var(--bg) 28%);
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px 1fr;
        }

        .sidebar {
            background: #0f172a;
            color: #e2e8f0;
            padding: 24px 18px;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.08em;
            margin-bottom: 24px;
            font-size: 20px;
        }

        .nav-group {
            display: grid;
            gap: 8px;
        }

        .nav-link {
            color: #cbd5e1;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 10px;
            display: block;
        }

        .nav-link:hover {
            background: #1e293b;
            color: #f8fafc;
        }

        .nav-link.active {
            background: #0f766e;
            color: #ecfeff;
            font-weight: 600;
        }

        .panel {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid var(--line);
            padding: 14px 22px;
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(8px);
        }

        .page-title {
            margin: 0;
            font-size: 22px;
        }

        .page-subtitle {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-chip {
            background: #ecfeff;
            color: #0f766e;
            border: 1px solid #99f6e4;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .content {
            padding: 22px;
            display: grid;
            gap: 16px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
        }

        .card-title {
            margin: 0;
            font-size: 18px;
        }

        .card-subtitle {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .card-content {
            padding: 16px 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-item {
            background: linear-gradient(120deg, #ffffff, #ecfeff);
            border: 1px solid #ccfbf1;
            border-radius: 12px;
            padding: 14px;
        }

        .stat-label {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .stat-value {
            margin: 8px 0 0;
            font-size: 30px;
            font-weight: 700;
            color: var(--brand-dark);
        }

        .form-grid {
            display: grid;
            gap: 12px;
        }

        .field {
            display: grid;
            gap: 6px;
        }

        .field label {
            font-size: 14px;
            font-weight: 600;
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            font-size: 14px;
        }

        .textarea {
            min-height: 110px;
            resize: vertical;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table th,
        .table td {
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            padding: 11px 10px;
            vertical-align: top;
        }

        .table th {
            color: #334155;
            font-weight: 700;
            font-size: 13px;
        }

        .status-pill {
            display: inline-block;
            border-radius: 999px;
            padding: 4px 9px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pill.active {
            background: #dcfce7;
            color: #166534;
        }

        .status-pill.inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--brand-dark);
        }

        .btn-light {
            background: #f8fafc;
            color: #0f172a;
            border: 1px solid #cbd5e1;
        }

        .btn-danger {
            background: #fef2f2;
            color: var(--danger);
            border: 1px solid #fecaca;
        }

        .actions-inline {
            display: inline-flex;
            gap: 8px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 14px;
        }

        .alert {
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid transparent;
            font-size: 14px;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: #86efac;
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border-color: #fca5a5;
        }

        .error-list {
            margin: 8px 0 0;
            padding-left: 18px;
        }

        .pagination-wrap {
            margin-top: 14px;
        }

        @media (max-width: 900px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 14px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">PANEL ADMINISTRATIVO</div>

            <nav class="nav-group">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">Dashboard</a>
                {{-- <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                    href="{{ route('roles.index') }}">Roles</a> --}}
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                    href="{{ route('users.index') }}">Usuarios</a>
            </nav>
        </aside>

        <div class="panel">
            <header class="topbar">
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-subtitle"></p>
                </div>

                <div class="topbar-right">
                    <span class="user-chip">{{ strtoupper(auth()->user()->name) }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-light" type="submit">Cerrar sesion</button>
                    </form>
                </div>
            </header>

            <main class="content">
                <x-flash-messages />
                @yield('content')
            </main>
        </div>
    </div>

    @if (session('swal_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.Swal) {
                    window.Swal.fire({
                        icon: 'success',
                        title: 'Listo',
                        text: @json(session('swal_success')),
                        confirmButtonText: 'OK'
                    });
                }
            });
        </script>
    @endif
</body>

</html>