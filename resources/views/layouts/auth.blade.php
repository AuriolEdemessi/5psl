<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>5PSL | @yield('title', 'Authentification')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('media/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --possible-blue: #0066ff;
            --possible-dark: #121212;
            --possible-green: #00ff00;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--possible-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar minimaliste pour auth */
        .auth-nav {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
        }
        .auth-nav-logo {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -1px;
            color: var(--possible-dark);
            text-decoration: none;
        }
        .auth-nav-logo span { color: var(--possible-blue); }

        .auth-split { display: flex; flex: 1; }
        
        /* Left Panel - Image/Presentation */
        .auth-left {
            flex: 1;
            background-color: var(--possible-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .auth-left h1 {
            font-size: 56px;
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1px;
            position: relative;
            z-index: 2;
            max-width: 500px;
        }
        
        /* Right Panel - Form */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: #ffffff;
        }
        .auth-right-content { max-width: 400px; width: 100%; }
        
        .auth-heading { font-size: 32px; font-weight: 800; color: var(--possible-dark); margin-bottom: 8px; }
        .auth-subheading { font-size: 16px; color: #666; margin-bottom: 32px; }
        
        .form-label-custom { font-size: 13px; font-weight: 700; color: var(--possible-dark); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-input {
            width: 100%; padding: 14px 16px;
            border: 2px solid #eee; border-radius: 4px;
            font-size: 16px; font-family: 'Inter', sans-serif;
            color: var(--possible-dark); background: #fff;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-input:focus { border-color: var(--possible-blue); }
        .form-input.is-invalid { border-color: #ef4444; }
        
        .btn-possible {
            width: 100%; padding: 16px;
            background: var(--possible-green); color: var(--possible-dark);
            border: none; border-radius: 4px;
            font-size: 16px; font-weight: 800;
            font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.5px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-possible:hover { transform: scale(1.02); }
        
        .auth-link { color: var(--possible-blue); font-weight: 700; text-decoration: none; }
        .auth-link:hover { text-decoration: underline; }
        
        .error-text { font-size: 13px; color: #ef4444; margin-top: 6px; font-weight: 500; }
        .alert-box {
            padding: 16px; border-radius: 4px;
            background: #fef2f2; border: 2px solid #fecaca;
            color: #dc2626; font-size: 14px; font-weight: 500;
            margin-bottom: 24px;
        }
        
        @media (max-width: 991px) {
            .auth-split { flex-direction: column; }
            .auth-left { padding: 60px 30px; min-height: 300px; }
            .auth-left h1 { font-size: 36px; }
            .auth-right { padding: 40px 24px; }
        }
    </style>
</head>
<body>
    <div class="auth-nav">
        <a href="/" class="auth-nav-logo"><span>5</span>PSL</a>
        <div style="display: flex; gap: 24px; align-items: center; font-size: 14px; font-weight: 600;">
            <a href="/#club" style="color: #666; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--possible-dark)'" onmouseout="this.style.color='#666'">Le Club</a>
            <a href="/#features" style="color: #666; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--possible-dark)'" onmouseout="this.style.color='#666'">Fonctionnalités</a>
            <div style="width: 1px; height: 16px; background: #eee;"></div>
            
            <div style="display: flex; gap: 8px; align-items: center;">
                <i class="fas fa-globe text-muted"></i>
                <a href="{{ route('lang.switch', 'fr') }}" style="color: {{ app()->getLocale() == 'fr' ? 'var(--possible-dark)' : '#94a3b8' }}; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--possible-dark)'" onmouseout="this.style.color='{{ app()->getLocale() == 'fr' ? 'var(--possible-dark)' : '#94a3b8' }}'">FR</a>
                <span style="color: #eee;">|</span>
                <a href="{{ route('lang.switch', 'en') }}" style="color: {{ app()->getLocale() == 'en' ? 'var(--possible-dark)' : '#94a3b8' }}; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--possible-dark)'" onmouseout="this.style.color='{{ app()->getLocale() == 'en' ? 'var(--possible-dark)' : '#94a3b8' }}'">EN</a>
            </div>
        </div>
    </div>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
