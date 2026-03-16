<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5PSL | Session expirée</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .container { text-align: center; padding: 40px 20px; max-width: 480px; }
        .icon { width: 80px; height: 80px; border-radius: 20px; background: #fffbeb; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 36px; }
        h1 { font-size: 28px; font-weight: 900; color: #121212; margin-bottom: 12px; }
        p { font-size: 15px; color: #64748b; line-height: 1.6; margin-bottom: 28px; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background: #0066ff; color: white; }
        .btn-primary:hover { background: #0052cc; }
        .btn-outline { background: white; color: #121212; border: 1.5px solid #e2e8f0; margin-left: 8px; }
        .btn-outline:hover { border-color: #121212; }
        .logo { font-size: 20px; font-weight: 900; color: #121212; margin-bottom: 32px; display: block; }
        .logo span { color: #0066ff; }
    </style>
    <meta http-equiv="refresh" content="3;url={{ url()->previous(url('/')) }}">
</head>
<body>
    <div class="container">
        <a href="{{ url('/') }}" class="logo"><span>5</span>PSL</a>
        <div class="icon">⏱</div>
        <h1>Session expirée</h1>
        <p>Votre session a expiré ou le formulaire a été soumis deux fois. Vous allez être redirigé automatiquement dans 3 secondes.</p>
        <a href="{{ url()->previous(url('/')) }}" class="btn btn-primary">← Retour</a>
        <a href="{{ route('login') }}" class="btn btn-outline">Se connecter</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ url()->previous(url('/')) }}";
        }, 3000);
    </script>
</body>
</html>
