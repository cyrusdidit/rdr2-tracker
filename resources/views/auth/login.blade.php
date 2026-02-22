<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RDR2 Progress Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #e0e0e0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-box {
            background: #222;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .login-box h1 {
            text-align: center;
            color: #d4af37;
            margin-bottom: 30px;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
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

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #d4af37;
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
            color: #1a1a1a;
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
            background: #f0c04f;
        }

        button:active {
            transform: scale(0.98);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .register-link a {
            color: #d4af37;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #f0c04f;
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
            border: 1px solid #4a9eff;
            color: #4a9eff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
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
