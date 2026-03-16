<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5PSL | Investissement Collectif</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('media/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --possible-blue: #0066ff;
            --possible-dark: #121212;
            --possible-green: #00ff00;
            --possible-light-blue: #e6f0ff;
            --possible-pink: #ffd1dc;
            --transition-speed: 0.3s;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: #ffffff; 
            color: var(--possible-dark); 
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Loader --- */
        #page-loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: var(--possible-dark);
            z-index: 9999999;
            background: #121212 !important;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }
        .loader-brand {
            font-size: 40px; font-weight: 900; color: white; letter-spacing: -2px;
            animation: pulse 1.5s infinite;
        }
        .loader-brand span { color: var(--possible-blue); }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* --- Animations --- */
        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        a { text-decoration: none; color: inherit; }

        /* Typography Utilities */
        .text-blue { color: var(--possible-blue) !important; }
        .text-green { color: var(--possible-green) !important; }
        .bg-blue { background-color: var(--possible-blue) !important; }
        .bg-dark { background-color: var(--possible-dark) !important; }
        
        .btn-possible {
            background-color: var(--possible-green);
            color: var(--possible-dark);
            font-weight: 800;
            padding: 12px 24px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-possible:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,255,0,0.2); color: var(--possible-dark); }
        
        .btn-outline-dark-custom {
            border: 2px solid var(--possible-dark);
            color: var(--possible-dark);
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            background: transparent;
            transition: all 0.2s;
        }
        .btn-outline-dark-custom:hover { background: var(--possible-dark); color: white; }

        /* Top Banner */
        .top-banner {
            background-color: var(--possible-dark);
            color: white;
            padding: 10px 0;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Navbar */
        .navbar-main {
            position: relative;
            z-index: 999;
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
        }
        .navbar-main.scrolled { padding: 12px 0; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .nav-links {
            display: flex;
            gap: 30px;
            font-weight: 600;
            font-size: 15px;
        }
        .nav-links a { position: relative; padding-bottom: 4px; }
        .nav-links a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: var(--possible-blue); transition: width 0.3s; }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--possible-blue); }

        /* Hero Split Section */
        .hero-split {
            display: flex;
            min-height: 85vh;
        }
        .hero-left {
            z-index: 1;
            flex: 1;
            background-color: var(--possible-blue);
            color: white;
            padding: 80px 8%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .hero-left::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: rotateBg 20s linear infinite;
        }
        @keyframes rotateBg { 100% { transform: rotate(360deg); } }

        .hero-left h1 {
            position: relative; z-index: 10;
            font-size: clamp(40px, 5vw, 64px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 30px;
            letter-spacing: -1px;
            position: relative; z-index: 2;
        }
        .hero-left p {
            position: relative; z-index: 10;
            font-size: clamp(16px, 2vw, 20px);
            font-weight: 500;
            opacity: 0.9;
            position: relative; z-index: 2;
            max-width: 600px;
        }
        .hero-right {
            flex: 1;
            background: var(--possible-dark);
            position: relative;
            overflow: hidden;
        }
        .hero-carousel {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }
        .hero-carousel-slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        .hero-carousel-slide.active {
            opacity: 1;
        }
        .hero-carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-carousel-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.3), rgba(0,102,255,0.15));
            z-index: 1;
        }

        /* Feature Large Text Centered */
        .large-text-section {
            padding: 120px 20px;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
        }
        .large-text-section h2 {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 800;
            line-height: 1.3;
            letter-spacing: -0.5px;
        }

        /* Split Cards Section */
        .split-cards { display: flex; flex-wrap: wrap; }
        .card-half {
            flex: 1; min-width: 50%;
            padding: 100px 8%;
            position: relative;
            overflow: hidden;
        }
        .card-black { background-color: var(--possible-dark); color: white; }
        .card-yellow { background-color: #fff9e6; }
        .card-pink { background-color: var(--possible-pink); }
        .card-light-blue { background-color: var(--possible-light-blue); }
        
        .card-half h3 { font-size: clamp(28px, 3vw, 36px); font-weight: 900; margin-bottom: 20px; line-height: 1.2; }
        .card-half p { font-size: 18px; opacity: 0.8; margin-bottom: 30px; line-height: 1.6; }
        
        /* Stats Counter Section */
        .stats-section {
            text-align: center;
            padding: 100px 20px;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            background: linear-gradient(to bottom, #ffffff, #f8fafc);
        }
        .stats-counter {
            font-size: clamp(40px, 6vw, 80px);
            font-weight: 300;
            color: var(--possible-blue);
            letter-spacing: 5px;
            font-family: monospace;
            margin: 20px 0;
        }

        /* Bottom Dark Section */
        .bottom-dark { background-color: var(--possible-dark); color: white; padding: 120px 8%; }
        .bottom-dark h2 { font-size: clamp(32px, 5vw, 56px); font-weight: 900; margin-bottom: 30px; letter-spacing: -1px; }

        /* Footer */
        footer { background-color: var(--possible-dark); color: white; padding: 80px 8% 40px; border-top: 1px solid rgba(255,255,255,0.1); }
        .footer-logo { font-size: 40px; font-weight: 900; letter-spacing: -2px; margin-bottom: 20px; display: block; }
        .footer-logo span { color: var(--possible-blue); }
        
        
        /* Mobile Menu */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: var(--possible-blue);
            z-index: 99999;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }
        .mobile-menu-overlay.active {
            transform: translateX(0);
        }
        .mobile-nav-links {
            display: flex;
            flex-direction: column;
            padding: 20px 40px;
            gap: 20px;
        }
        .mobile-nav-links a {
            color: white;
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
        }
        @media (max-width: 992px) {
            .hero-split, .split-cards { flex-direction: column; }
            .card-half { min-width: 100%; padding: 60px 5%; }
            .nav-links { display: none; }
            .hero-right { min-height: 400px; }
            .navbar-main .d-none.d-lg-block { display: none !important; }
            .hero-left .btn-possible { display: block; width: 100%; text-align: center; }
            .navbar-main { padding: 15px 20px !important; }
        }
    </style>
</head>
<body>

    <!-- Loader -->
    <div id="page-loader">
        <div class="loader-brand"><span>5</span>PSL</div>
    </div>

    <!-- Top Banner (Dynamic) -->
    <div class="top-banner px-4 px-md-5">
        <div class="d-none d-md-block">
            @auth
                {{ __('Bon retour,') }} <strong>{{ Auth::user()->name }}</strong>. 
                <span style="opacity: 0.6; margin-left: 8px;">{{ __('Niveau:') }} <span style="color: var(--possible-green);">{{ Auth::user()->tier ?? 'STARTER' }}</span></span>
            @else
                {{ __('Rejoignez un club d\'investissement innovant basé sur la Valeur Liquidative (NAV).') }}
            @endauth
        </div>
        <div class="d-block d-md-none fw-bold">5PSL CLUB</div>

        <div style="display: flex; gap: 20px; align-items: center;">
            <div style="display: flex; gap: 8px; align-items: center; font-size: 12px; font-weight: 700;">
                <a href="{{ route('lang.switch', 'fr') }}" style="color: {{ app()->getLocale() == 'fr' ? 'var(--possible-green)' : 'rgba(255,255,255,0.5)' }}; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='{{ app()->getLocale() == 'fr' ? 'var(--possible-green)' : 'rgba(255,255,255,0.5)' }}'">FR</a>
                <span style="color: rgba(255,255,255,0.2);">|</span>
                <a href="{{ route('lang.switch', 'en') }}" style="color: {{ app()->getLocale() == 'en' ? 'var(--possible-green)' : 'rgba(255,255,255,0.5)' }}; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='{{ app()->getLocale() == 'en' ? 'var(--possible-green)' : 'rgba(255,255,255,0.5)' }}'">EN</a>
            </div>
            
            <div style="width: 1px; height: 12px; background: rgba(255,255,255,0.2);"></div>
            
            @auth
                <div style="display: flex; align-items: center; gap: 12px; font-size: 13px;">
                    <a href="{{ route('investment.dashboard') }}" class="text-white" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='white'">
                        <i class="fas fa-chart-pie me-1"></i> {{ __('Mon Portefeuille') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: rgba(255,255,255,0.5); font-weight: 600; font-size: 12px; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='var(--possible-pink)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </div>
            @else
                <div>
                    <a href="{{ route('login') }}" class="text-white me-3" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='white'">{{ __('Connexion') }}</a>
                    <a href="{{ route('register') }}" class="text-green" style="transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">{{ __('Inscription') }}</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar-main px-4 px-md-5" id="mainNav">
        <a href="/" style="font-size: 28px; font-weight: 900; letter-spacing: -1px; text-decoration: none; color: var(--possible-dark);">
            <span class="text-blue">5</span>PSL
        </a>
        <div class="nav-links">
            <a href="#club">{{ __('Le Club') }}</a>
            <a href="#nav">{{ __(' Méthode') }}</a>
            <a href="#allocation">{{ __('Stratégie') }}</a>
            <a href="{{ route('whitepaper') }}" class="text-blue"><i class="fas fa-file-alt me-1"></i> {{ __('Whitepaper') }}</a>
        </div>
        <div class="d-none d-lg-block">
            @auth
                <a href="{{ route('investment.dashboard') }}" class="btn-possible" style="background: var(--possible-blue); color: white;">
                    {{ __('Mon Compte') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-possible">{{ __('Rejoindre le club') }}</a>
            @endauth
        </div>
        <div class="d-block d-lg-none">
            <button class="btn btn-link text-dark p-0" id="mobileMenuBtn" style="font-size: 24px; text-decoration: none;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <div class="d-flex justify-content-between align-items-center p-4">
            <a href="/" style="font-size: 28px; font-weight: 900; letter-spacing: -1px; color: white; text-decoration: none;">
                <span class="text-green">5</span>PSL
            </a>
            <button class="btn btn-link text-white p-0" id="closeMenuBtn" style="font-size: 28px; text-decoration: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-nav-links">
            <a href="#club" class="mobile-link">{{ __('Le Club') }}</a>
            <a href="#nav" class="mobile-link">{{ __('Méthode') }}</a>
            <a href="#allocation" class="mobile-link">{{ __('Stratégie') }}</a>
            <a href="{{ route('whitepaper') }}" class="mobile-link text-green"><i class="fas fa-file-alt me-2"></i>{{ __('Whitepaper') }}</a>
            
            <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
            
            @auth
                <a href="{{ route('investment.dashboard') }}" class="btn-possible d-flex align-items-center justify-content-center" style="background: white; color: var(--possible-blue);">
                    {{ __('Mon Compte') }} <i class="fas fa-arrow-right ms-2"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="mobile-link mb-2" style="font-size: 20px;">{{ __('Connexion') }}</a>
                <a href="{{ route('register') }}" class="btn-possible d-flex align-items-center justify-content-center" style="background: var(--possible-green); color: var(--possible-dark); border: none;">
                    {{ __('Rejoindre le club') }}
                </a>
            @endauth
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-split">
        <div class="hero-left">
            <h1 class="fade-up">{!! nl2br(e(__("L'investissement intelligent, transparent et collectif."))) !!}</h1>
            <p class="fade-up" style="transition-delay: 0.1s;">{{ __('Rejoignez le premier club d\'investissement basé sur la méthode NAV. Sanctuarisez votre capital, votez pour les opportunités et gagnez avec la force du groupe.') }}</p>
            
            <div class="mt-5 fade-up" style="position: relative; z-index: 10; transition-delay: 0.2s;" style="transition-delay: 0.2s;">
                @auth
                    <a href="{{ route('investment.dashboard') }}" class="btn-possible mb-3" style="background: white; color: var(--possible-dark); font-size: 16px; padding: 16px 32px;">
                        <i class="fas fa-chart-line text-blue"></i> {{ __('Mon Portefeuille') }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-possible mb-3" style="background: var(--possible-green); font-size: 16px; padding: 16px 32px;">
                        {{ __('Rejoindre le Club') }} <i class="fas fa-arrow-right"></i>
                    </a>
                @endauth
                <div style="font-size: 12px; color: rgba(255,255,255,0.7); display: flex; gap: 16px; align-items: center; margin-top: 8px;">
                    <span><i class="fas fa-check-circle text-green me-1"></i> Règle du High-Water Mark</span>
                    <span><i class="fas fa-check-circle text-green me-1"></i> Retraits mensuels</span>
                </div>
            </div>
        </div>
        <div class="hero-right">
            <div class="hero-carousel" id="heroCarousel">
                <div class="hero-carousel-slide active">
                    <img src="{{ asset('media/img/bg2.jpg') }}" alt="5PSL Investissement">
                </div>

                <div class="hero-carousel-slide">
                    <img src="{{ asset('media/img/bg5.jpg') }}" alt="5PSL Club">
                </div>
                
                <div class="hero-carousel-slide">
                    <img src="{{ asset('media/img/bg3.jpg') }}" alt="5PSL Club">
                </div>
               
            </div>
            <div class="hero-carousel-overlay"></div>
        </div>
    </section>

    <!-- Large Text Section -->
    <section class="large-text-section fade-up" id="club">
        <h2>
            {!! preg_replace('/(Valeur Liquidative|allocation stricte 50\/30\/20|High-Water Mark)/i', '<span class="text-blue">$1</span>', __("5PSL redéfinit la confiance avec une gestion basée sur la Valeur Liquidative, une allocation stricte 50/30/20 et une protection totale via la règle du High-Water Mark.")) !!}
        </h2>
    </section>

    <!-- Split Cards Section: NAV & HWM -->
    <section class="split-cards" id="nav">
        <div class="card-half card-black fade-up">
            <div class="d-flex align-items-center mb-4">
                <div style="width: 48px; height: 48px; background: rgba(0,102,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-calculator text-blue fs-4"></i>
                </div>
                <h4 class="mb-0 fw-bold">{{ __('Méthode de la Valeur Liquidative (NAV)') }}</h4>
            </div>
            <h3>{!! nl2br(e(__("Une équité mathématique parfaite."))) !!}</h3>
            <p>{{ __('Vous n\'achetez pas une somme fixe, mais des parts du club. Si le club performe, la valeur de vos parts monte en temps réel. Cette méthode protège les anciens membres et garantit une entrée juste aux nouveaux.') }}</p>
            
            <div class="mt-4 p-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; font-family: monospace; color: var(--possible-green);">
                NAV = (Total Actifs) / (Total Parts en circulation)
            </div>
        </div>
        
        <div class="card-half card-light-blue fade-up d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center mb-4">
                <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-mountain text-blue fs-4"></i>
                </div>
                <h4 class="mb-0 fw-bold text-blue">{{ __('Protection des commissions') }}</h4>
            </div>
            <h3>{!! nl2br(e(__("Le gestionnaire ne gagne que si vous gagnez."))) !!}</h3>
            <p>{{ __('Grâce à la règle du High-Water Mark (sommet historique), la commission de performance de 30% n\'est prélevée QUE sur vos nouveaux profits. Si votre portefeuille baisse, aucune commission n\'est payée tant que vos pertes ne sont pas effacées.') }}</p>
            
            <a href="{{ route('whitepaper') }}#s5" class="btn-possible mt-3 bg-dark text-white border-0">{{ __('Lire les détails dans le Whitepaper') }}</a>
        </div>
    </section>

    <!-- Split Cards Section: Allocation & Affiliation -->
    <section class="split-cards" id="allocation">
        <div class="card-half card-yellow fade-up">
            <div class="d-flex align-items-center mb-4">
                <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                    <i class="fas fa-chart-pie text-dark fs-4"></i>
                </div>
                <h4 class="mb-0 fw-bold">{{ __('Stratégie 50/30/20') }}</h4>
            </div>
            <h3>{!! nl2br(e(__("Un rempart contre la volatilité."))) !!}</h3>
            <p>{{ __('Nous sécurisons 50% du capital sur des actifs sans risque pour garantir la liquidité des retraits. 30% sont alloués à la croissance stable, et seuls 20% visent la haute performance (crypto, opportunités).') }}</p>
            
            <div style="height: 16px; display: flex; border-radius: 8px; overflow: hidden; margin-top: 30px;">
                <div style="width: 50%; background: var(--possible-blue);" title="50% Sécurité"></div>
                <div style="width: 30%; background: #059669;" title="30% Croissance"></div>
                <div style="width: 20%; background: #f59e0b;" title="20% Opportunité"></div>
            </div>
            <div class="d-flex justify-content-between mt-2" style="font-size: 12px; font-weight: 700; color: #666;">
                <span>Sécurité</span>
                <span>Croissance</span>
                <span>Opportunité</span>
            </div>
        </div>

        <div class="card-half card-pink fade-up">
            <div class="d-flex align-items-center mb-4">
                <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                    <i class="fas fa-handshake text-dark fs-4"></i>
                </div>
                <h4 class="mb-0 fw-bold">{{ __('Programme d\'Affiliation') }}</h4>
            </div>
            <h3>{!! nl2br(e(__("Bâtissez un revenu passif."))) !!}</h3>
            <p>{{ __('Parrainez de nouveaux membres et touchez 10% de la commission de performance du gestionnaire sur leurs gains. Cela ne coûte rien à votre filleul, la récompense est tirée directement de la part du club !') }}</p>
            
            <div style="background: white; padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 16px; margin-top: 20px;">
                <div style="font-size: 32px; font-weight: 900; color: #059669;">10%</div>
                <div style="font-size: 13px; font-weight: 600; line-height: 1.4;">De commission reversée à vie sur les bénéfices nets de vos invités.</div>
            </div>
        </div>
    </section>

    <!-- Stats Counter -->
    <section class="stats-section fade-up" id="stats">
        <div style="font-weight: 800; text-transform: uppercase; color: var(--possible-blue); font-size: 14px; letter-spacing: 1px;">{{ __('NAV Actuelle (USD)') }}</div>
        @php
            $currentNav = \App\Models\GlobalStat::current()->current_nav ?? '10.00000000';
        @endphp
        <div class="stats-counter" style="font-weight: 900;">${{ number_format((float)$currentNav, 2, '.', ' ') }}</div>
        <div style="font-weight: 600; font-size: 18px; color: #666;">{{ __('Le prix en temps réel d\'une part du club') }}</div>
    </section>

    <!-- Tiers Section -->
    <section class="py-5 bg-light fade-up">
        <div class="container py-5">
            <h2 class="text-center mb-2" style="font-size: 36px; font-weight: 900; letter-spacing: -1px;">{{ __('Des paliers adaptés à vos ambitions') }}</h2>
            <p class="text-center mb-5" style="color: #666;">{{ __('Frais d\'adhésion annuels servant à l\'innovation et la maintenance technique.') }}</p>
            
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="bg-white p-5 h-100 text-center" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 12px;">Starter</div>
                        <div style="font-size: 40px; font-weight: 900; color: var(--possible-dark);">$20<span style="font-size: 14px; color: #94a3b8;">/an</span></div>
                        <div style="margin: 20px 0; padding: 10px; background: #f8fafc; border-radius: 8px; font-size: 13px; font-weight: 600;">$100 — $2,500 de capital</div>
                        <p style="font-size: 13px; color: #666; margin-bottom: 30px;">Parfait pour débuter en douceur dans l'investissement collectif avec la protection NAV.</p>
                        <a href="{{ route('register') }}" class="btn-outline-dark-custom w-100">Rejoindre</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-5 h-100 text-center" style="border-radius: 16px; border: 2px solid var(--possible-blue); box-shadow: 0 20px 40px rgba(0,102,255,0.1); position: relative;">
                        <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--possible-blue); color: white; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; text-transform: uppercase;">Populaire</div>
                        <div style="font-size: 14px; font-weight: 800; text-transform: uppercase; color: var(--possible-blue); margin-bottom: 12px;">Pro</div>
                        <div style="font-size: 40px; font-weight: 900; color: var(--possible-dark);">$50<span style="font-size: 14px; color: #94a3b8;">/an</span></div>
                        <div style="margin: 20px 0; padding: 10px; background: rgba(0,102,255,0.05); border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--possible-blue);">$2,500 — $10,000 de capital</div>
                        <p style="font-size: 13px; color: #666; margin-bottom: 30px;">Pour les investisseurs réguliers souhaitant optimiser leurs rendements grâce aux intérêts composés.</p>
                        <a href="{{ route('register') }}" class="btn-possible bg-blue text-white w-100">Rejoindre</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white p-5 h-100 text-center" style="border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div style="font-size: 14px; font-weight: 800; text-transform: uppercase; color: #f59e0b; margin-bottom: 12px;">Elite</div>
                        <div style="font-size: 40px; font-weight: 900; color: var(--possible-dark);">$100<span style="font-size: 14px; color: #94a3b8;">/an</span></div>
                        <div style="margin: 20px 0; padding: 10px; background: #fffbeb; border-radius: 8px; font-size: 13px; font-weight: 600; color: #b45309;">+ $10,000 de capital</div>
                        <p style="font-size: 13px; color: #666; margin-bottom: 30px;">Le niveau maximal avec un poids prépondérant dans les votes communautaires.</p>
                        <a href="{{ route('register') }}" class="btn-outline-dark-custom w-100">Rejoindre</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Dark Section -->
    <section class="bottom-dark fade-up" id="join">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 style="font-size: clamp(32px, 5vw, 56px); line-height: 1.1; letter-spacing: -2px;">{!! nl2br(e(__("Commencez à bâtir votre patrimoine avec 5PSL."))) !!}</h2>
                    <p style="font-size: 20px; opacity: 0.8; margin-bottom: 40px; line-height: 1.6;">{{ __('Rejoignez des investisseurs intelligents qui mutualisent leurs forces pour faire fructifier leur capital, protégés par la transparence de la blockchain.') }}</p>
                    
                    @auth
                        <a href="{{ route('investment.dashboard') }}" class="btn-possible bg-white px-5 py-3 fs-5" style="color: var(--possible-dark);">{{ __('Aller au Dashboard') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-possible px-5 py-3 fs-5">{{ __('Créer mon compte maintenant') }}</a>
                    @endauth
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <div style="background: rgba(255,255,255,0.05); padding: 60px; border-radius: 24px; display: inline-block; border: 1px solid rgba(255,255,255,0.1); box-shadow: inset 0 0 40px rgba(0,0,0,0.5);">
                        <div style="font-size: 100px; font-weight: 900; line-height: 1; letter-spacing: -5px; color: var(--possible-blue);">5PSL</div>
                        <div style="font-size: 18px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-top: 10px; color: var(--possible-green);">{{ __('Club d\'Investissement') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid" style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: space-between; margin-bottom: 60px;">
                <div style="flex: 1; min-width: 300px;">
                    <a href="/" class="footer-logo" style="font-size: 32px; font-weight: 900; letter-spacing: -1px; margin-bottom: 16px; display: inline-block;">
                        <span class="text-blue">5</span>PSL
                    </a>
                    <p style="opacity: 0.7; font-size: 15px; max-width: 350px; line-height: 1.6;">
                        {{ __('Le club d\'investissement collectif conçu pour être transparent, démocratique et performant.') }}
                    </p>
                    <div style="display: flex; gap: 16px; margin-top: 24px;">
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--possible-blue)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--possible-blue)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='var(--possible-blue)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div style="display: flex; gap: 80px; flex-wrap: wrap;">
                    <div>
                        <div style="font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; color: var(--possible-blue);">{{ __('Plateforme') }}</div>
                        <ul class="list-unstyled" style="opacity: 0.8; line-height: 2.5; font-size: 15px;">
                            <li><a href="{{ route('login') }}" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='inherit'">{{ __('Connexion') }}</a></li>
                            <li><a href="{{ route('register') }}" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='inherit'">{{ __('Inscription') }}</a></li>
                            <li><a href="{{ route('whitepaper') }}" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='inherit'">{{ __('Whitepaper') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; color: var(--possible-blue);">{{ __('Légal') }}</div>
                        <ul class="list-unstyled" style="opacity: 0.8; line-height: 2.5; font-size: 15px;">
                            <li><a href="#" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='inherit'">{{ __('Conditions d\'utilisation') }}</a></li>
                            <li><a href="#" style="transition: color 0.2s;" onmouseover="this.style.color='var(--possible-green)'" onmouseout="this.style.color='inherit'">{{ __('Politique de confidentialité') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div style="opacity: 0.6; font-size: 14px;">
                    &copy; {{ date('Y') }} 5PSL {{ __('Club d\'Investissement') }}. {{ __('Tous droits réservés.') }}
                </div>
                <div style="font-size: 14px; opacity: 0.6;">
                    {{ __('Propulsé') }} <i class="fas fa-heart" style="color: #ff3333;"></i> {{ __('par CRACLABS.') }}
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Loader logic
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                    initAnimations();
                }, 500);
            }, 500); // Minimum display time
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Hero Carousel — fade rotation
        (function() {
            const slides = document.querySelectorAll('#heroCarousel .hero-carousel-slide');
            if (slides.length < 2) return;
            let current = 0;
            setInterval(function() {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, 5000);
        })();

        // Scroll animations (Intersection Observer)
        function initAnimations() {
            const elements = document.querySelectorAll('.fade-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            elements.forEach(el => observer.observe(el));
        }
    
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        if(mobileMenuBtn && closeMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });

            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
        }

    </script>
</body>
</html>
