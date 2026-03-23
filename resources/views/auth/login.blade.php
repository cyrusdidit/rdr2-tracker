
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RDR2 Progress Tracker</title>
    <style>
                body {
                    font-family: 'Arial', sans-serif;
                    min-height: 100vh;
                    color: var(--text);
                    transition: background 0.3s, color 0.3s;
                }
                [data-theme="dark"] body, :root:not([data-theme="light"]) body {
                    background: #000 !important;
                }
                [data-theme="light"] body {
                    background: #fff !important;
                }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --box-bg: #23272f;
            --text: #f5f6fa;
            --accent: #ffd700;
            --input-bg: #181a1b;
            --input-border: #444c56;
            --error: #ff6b6b;
            --info-bg: #23272f;
            --info-border: #ffd700;
            --info-text: #ffd700;
        }
        [data-theme="dark"], :root:not([data-theme="light"]) {
            --bg: #000;
            --accent: #ff3b3b;
            --info-border: #ff3b3b;
            --info-text: #ff3b3b;
        }
        [data-theme="light"] {
            --bg: #f4f6fb;
            --box-bg: #fffbe6;
            --text: #23272f;
            --accent: #bfa133;
            --input-bg: #fff;
            --input-border: #bfa133;
            --error: #d7263d;
            --info-bg: #fffbe6;
            --info-border: #bfa133;
            --info-text: #bfa133;
        }
        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: #222;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }
            .login-box {
                background: var(--box-bg);
                border: 2px solid var(--accent);
                border-radius: 8px;
                padding: 40px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
                width: 100%;
                max-width: 400px;
                position: relative;
            }
        .login-box h1 {
            text-align: center;
            color: #d4af37;
            margin-bottom: 30px;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
            .login-box h1 {
                text-align: center;
                color: var(--accent);
                margin-bottom: 30px;
                font-size: 28px;
                text-transform: uppercase;
                letter-spacing: 2px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            .theme-toggle-btn {
                background: none;
                border: none;
                color: var(--accent);
                font-size: 1.3em;
                margin-left: 10px;
                cursor: pointer;
                transition: color 0.3s;
            }
            .theme-toggle-btn:hover {
                color: var(--text);
            }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #d4af37;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
            label {
                display: block;
                margin-bottom: 8px;
                color: var(--accent);
                font-weight: bold;
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #444;
            border-radius: 4px;
            background: #1a1a1a;
            color: #e0e0e0;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
            input[type="email"],
            input[type="password"] {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid var(--input-border);
                border-radius: 4px;
                background: var(--input-bg);
                color: var(--text);
                font-size: 14px;
                transition: border-color 0.3s ease;
            }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #d4af37;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        }
            input[type="email"]:focus,
            input[type="password"]:focus {
                outline: none;
                border-color: var(--accent);
                box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
            }
        .error-message {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #d4af37;
            color: #222;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 24px;
        }
            button {
                width: 100%;
                padding: 12px;
                background: var(--accent);
                color: var(--box-bg);
                border: none;
                border-radius: 4px;
                font-size: 16px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1px;
                cursor: pointer;
                transition: background 0.3s ease;
                margin-top: 24px;
            }
            button:hover {
                background: var(--text);
                color: var(--accent);
            }
        button:hover {
            background: #bfa133;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            width: 100%;
        }
        .register-link a {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
            .register-link a {
                color: var(--accent);
                text-decoration: none;
                font-weight: bold;
                transition: color 0.3s ease;
            }
        .register-link a:hover {
            color: #bfa133;
        }
        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }
        .alert-danger {
            background: #3a1a1a;
            border: 1px solid #ff6b6b;
            color: #ff6b6b;
        }
        .alert-info {
            background: #1a2a3a;
            border: 1px solid #37aaff;
            color: #37aaff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>LOGIN</h1>
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
                <button class="theme-toggle-btn" id="themeToggleBtn" title="Toggle theme" style="margin: 24px auto 0 auto; display: block;">
                    <span id="themeIcon">🌙</span>
                </button>
        </div>
    </div>
</body>
</html>
</html>
<script>
    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        document.getElementById('themeIcon').textContent = theme === 'dark' ? '🌙' : '☀️';
    }
    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || 'dark';
        setTheme(current === 'dark' ? 'light' : 'dark');
    }
    window.addEventListener('DOMContentLoaded', function() {
        document.getElementById('themeToggleBtn').addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
        const saved = localStorage.getItem('theme');
        setTheme(saved === 'light' ? 'light' : 'dark');
    });
</script>

        button:hover {
            background: #bfa133;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            width: 100%;
        }

        .register-link a {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #bfa133;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert-danger {
            background: var(--input-bg);
            border: 1px solid var(--error);
            color: var(--error);
        }

        .alert-info {
            background: var(--info-bg);
            border: 1px solid var(--info-border);
            color: var(--info-text);
        }

            .login-box {
                /* see above for new .login-box rules */
            }

            .login-box h1 {
                text-align: center;
                color: var(--accent-primary);
                margin-top: 18px;
                margin-bottom: 30px;
                font-size: 28px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        document.getElementById('themeToggleBtn').addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
        const saved = localStorage.getItem('theme');
        if (saved) setTheme(saved);
    });
</script>

    <div class="container">
        <div class="login-box">
            <h1>LOGIN</h1>
            @if (session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        </div>
    </div>
                    </body>
                </html>
