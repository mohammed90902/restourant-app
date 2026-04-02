<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restaurant Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:200,300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --primary: #FF8C00;
            --primary-light: #FFA500;
            --glass: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .auth-container {
            width: 100%;
            max-width: 380px;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            border: 1px solid var(--glass-border);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            color: var(--primary-light);
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .auth-form input {
            width: 100%;
            padding: 12px 16px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: white;
            font-size: 0.95rem;
            box-sizing: border-box;
        }

        .auth-form input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(255, 140, 0, 0.3);
        }

        .auth-form button {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 0.5rem;
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .form-footer a {
            color: var(--primary-light);
            text-decoration: none;
            display: inline-block;
            margin: 0.25rem 0;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.8rem;
            margin: -0.5rem 0 0.5rem 0.25rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }

        .remember-me input {
            width: auto;
            margin-right: 0.5rem;
        }

        @media (max-width: 480px) {
            .auth-container {
                padding: 1.5rem;
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>

    <script>
        function toggleForms() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }

        // Show register form if errors exist
        document.addEventListener('DOMContentLoaded', function() {
            const registerErrors = document.querySelectorAll('[id^="register-"]');
            if (registerErrors.length > 0) {
                toggleForms();
            }
        });
    </script>
</body>
</html>