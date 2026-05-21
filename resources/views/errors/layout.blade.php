<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error @yield('code') – @yield('title') | {{ config('app.name') }}</title>
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            padding: 1.5rem;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .error-icon {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1.5rem;
            background: #eff6ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-icon svg {
            width: 2rem;
            height: 2rem;
            color: #3b82f6;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: #3b82f6;
            line-height: 1;
            letter-spacing: -3px;
            margin-bottom: 0.75rem;
        }

        .error-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .error-message {
            font-size: 0.9375rem;
            color: #64748b;
            line-height: 1.65;
            margin-bottom: 2rem;
        }

        .btn-group {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background: #3b82f6;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-ghost {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-ghost:hover {
            background: #e2e8f0;
        }

        .divider {
            width: 3rem;
            height: 3px;
            background: #3b82f6;
            border-radius: 2px;
            margin: 0 auto 1.5rem;
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        @media (max-width: 480px) {
            .card {
                padding: 2rem 1.5rem;
            }

            .error-code {
                font-size: 4rem;
            }
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #0f172a;
                color: #e2e8f0;
            }

            .card {
                background: #1e293b;
                border-color: #334155;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.3);
            }

            .error-icon {
                background: #1e3a5f;
            }

            .error-title {
                color: #f1f5f9;
            }

            .error-message {
                color: #94a3b8;
            }

            .btn-ghost {
                background: #334155;
                color: #cbd5e1;
            }

            .btn-ghost:hover {
                background: #475569;
            }

            .footer {
                color: #475569;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="error-icon">
            @yield('icon')
        </div>

        <div class="error-code">@yield('code')</div>
        <div class="divider"></div>
        <h1 class="error-title">@yield('title')</h1>
        <p class="error-message">@yield('message')</p>

        <div class="btn-group">
            <a href="javascript:history.back()" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            @auth
                <a href="{{ url('/admin') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            @else
                <a href="{{ url('/admin/login') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endauth
        </div>
    </div>

    <p class="footer">{{ config('app.name') }}</p>
</body>

</html>
