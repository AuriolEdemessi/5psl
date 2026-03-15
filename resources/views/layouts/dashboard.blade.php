<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>5PSL | @yield('title', 'Dashboard')</title>
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
            --sidebar-w: 272px;
            --topbar-h: 72px;
            --color-text: #334155;
            --color-muted: #94a3b8;
            --color-border: #e2e8f0;
            --color-success: #059669;
            --color-danger: #dc2626;
            --color-warning: #d97706;
            --radius: 10px;
            --radius-lg: 14px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; color: var(--possible-dark); min-height: 100vh; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
            background: var(--possible-dark); color: white;
            z-index: 100; display: flex; flex-direction: column; transition: transform 0.3s;
            overflow: hidden;
        }
        .sidebar-logo {
            padding: 28px 24px; display: flex; align-items: center; gap: 12px;
            font-size: 26px; font-weight: 900; letter-spacing: -1px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo span { color: var(--possible-blue); }
        .sidebar-nav { flex: 1; padding: 20px 14px; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 0; }
        .nav-section { font-size: 10px; font-weight: 800; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1.2px; padding: 18px 18px 8px; }
        .nav-item {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 18px; border-radius: 8px;
            font-size: 14px; font-weight: 600; color: rgba(255,255,255,0.55);
            transition: all 0.2s; margin-bottom: 2px; position: relative;
        }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.9); }
        .nav-item.active { background: var(--possible-blue); color: white; box-shadow: 0 4px 12px rgba(0,102,255,0.3); }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; opacity: 0.8; }
        .nav-item.active i { opacity: 1; }
        .nav-badge { background: var(--possible-green); color: var(--possible-dark); font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px; margin-left: auto; }
        
        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .sidebar-user { display: flex; align-items: center; gap: 12px; }
        .sidebar-avatar {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--possible-blue); color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 15px; flex-shrink: 0;
        }
        .sidebar-user-info { overflow: hidden; }
        .sidebar-user-info .user-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-info .user-role { font-size: 11px; color: rgba(255,255,255,0.4); text-transform: capitalize; }

        /* ── Topbar ── */
        .topbar {
            position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: var(--topbar-h);
            background: white; border-bottom: 1px solid var(--color-border);
            z-index: 90; display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-title { font-size: 20px; font-weight: 800; color: var(--possible-dark); letter-spacing: -0.3px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        
        .btn-topbar {
            padding: 8px 20px; border-radius: 6px;
            font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s;
            border: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-topbar-outline { background: transparent; color: var(--possible-dark); border: 1.5px solid var(--color-border); }
        .btn-topbar-outline:hover { border-color: var(--possible-dark); }
        
        .mobile-toggle { display: none; background: none; border: none; font-size: 22px; color: var(--possible-dark); cursor: pointer; }

        /* ── Main ── */
        .main-content { margin-left: var(--sidebar-w); padding: calc(var(--topbar-h) + 32px) 32px 48px; min-height: 100vh; }

        /* ── Cards ── */
        .card-5psl {
            background: white; border-radius: var(--radius-lg); border: 1px solid var(--color-border);
            padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: box-shadow 0.3s;
        }
        .card-5psl:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
        .card-5psl-flat { box-shadow: none; }
        .card-5psl-flat:hover { box-shadow: none; }
        
        .kpi-card { text-align: left; position: relative; overflow: hidden; }
        .kpi-card::after {
            content: ''; position: absolute; top: -30px; right: -30px;
            width: 100px; height: 100px; border-radius: 50%;
            background: rgba(0,0,0,0.02);
        }
        .kpi-icon {
            width: 48px; height: 48px; border-radius: var(--radius);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 16px;
        }
        .kpi-value { font-size: 28px; font-weight: 900; color: var(--possible-dark); margin-bottom: 4px; letter-spacing: -0.5px; line-height: 1.1; }
        .kpi-label { font-size: 12px; color: var(--color-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── Tables ── */
        .table-5psl { width: 100%; border-collapse: collapse; }
        .table-5psl thead th { font-size: 11px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 20px; border-bottom: 1px solid var(--color-border); background: #f8fafc; }
        .table-5psl thead th:first-child { border-radius: var(--radius) 0 0 0; }
        .table-5psl thead th:last-child { border-radius: 0 var(--radius) 0 0; }
        .table-5psl tbody td { padding: 16px 20px; font-size: 14px; font-weight: 500; color: var(--color-text); border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .table-5psl tbody tr:hover { background: #f8fafc; }
        .table-5psl tbody tr:last-child td { border-bottom: none; }

        /* ── Badges ── */
        .badge-5psl { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; display: inline-flex; align-items: center; gap: 4px; }
        .badge-success { background: #ecfdf5; color: var(--color-success); }
        .badge-warning { background: #fffbeb; color: var(--color-warning); }
        .badge-danger { background: #fef2f2; color: var(--color-danger); }
        .badge-info { background: var(--possible-light-blue); color: var(--possible-blue); }
        .badge-dark { background: rgba(0,0,0,0.06); color: var(--possible-dark); }

        /* ── Buttons ── */
        .btn-possible {
            padding: 11px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; border: none;
            cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px;
            letter-spacing: 0.2px;
        }
        .btn-possible:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .btn-possible-primary { background: var(--possible-blue); color: white; }
        .btn-possible-success { background: var(--possible-green); color: var(--possible-dark); }
        .btn-possible-dark { background: var(--possible-dark); color: white; }
        .btn-possible-outline { background: white; color: var(--possible-dark); border: 1.5px solid var(--color-border); }
        .btn-possible-outline:hover { border-color: var(--possible-dark); }
        .btn-possible-sm { padding: 7px 14px; font-size: 12px; border-radius: 6px; }
        .btn-possible-xs { padding: 4px 10px; font-size: 11px; border-radius: 5px; font-weight: 700; }

        /* ── Forms ── */
        .input-5psl {
            width: 100%; padding: 12px 16px; border: 1.5px solid var(--color-border); border-radius: 8px;
            font-size: 15px; font-weight: 500; font-family: 'Inter', sans-serif;
            color: var(--possible-dark); background: white; outline: none; transition: border-color 0.2s;
        }
        .input-5psl:focus { border-color: var(--possible-blue); box-shadow: 0 0 0 3px rgba(0,102,255,0.08); }
        .input-5psl::placeholder { color: var(--color-muted); }
        .form-label-custom { font-size: 12px; font-weight: 700; color: var(--color-text); margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── Sections ── */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
        .section-title-sm { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; color: var(--possible-dark); }
        .section-subtitle { font-size: 14px; color: var(--color-muted); margin-top: 2px; }

        /* ── Alerts ── */
        .alert-5psl { padding: 14px 20px; border-radius: var(--radius); font-size: 14px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-5psl-success { background: #ecfdf5; color: var(--color-success); border: 1px solid #a7f3d0; }
        .alert-5psl-danger { background: #fef2f2; color: var(--color-danger); border: 1px solid #fecaca; }
        .alert-5psl-warning { background: #fffbeb; color: var(--color-warning); border: 1px solid #fde68a; }
        .alert-5psl-info { background: var(--possible-light-blue); color: var(--possible-blue); border: 1px solid #bfdbfe; }

        /* ── Empty States ── */
        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state-icon { width: 64px; height: 64px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: var(--color-muted); font-size: 24px; }
        .empty-state h4 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .empty-state p { font-size: 14px; color: var(--color-muted); max-width: 320px; margin: 0 auto; }

        /* ── Utility ── */
        .text-mono { font-variant-numeric: tabular-nums; }
        .fw-900 { font-weight: 900 !important; }
        .text-success-custom { color: var(--color-success); }
        .text-danger-custom { color: var(--color-danger); }
        .text-muted-custom { color: var(--color-muted); }
        .gap-3 { gap: 12px; }

        /* ── Animations ── */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes countUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out both; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out both; }
        .animate-slide-right { animation: slideInRight 0.4s ease-out both; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out both; }
        .animate-count { animation: countUp 0.6s ease-out both; }
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.2s; }
        .delay-5 { animation-delay: 0.25s; }
        .delay-6 { animation-delay: 0.3s; }

        /* ── Loading Skeleton ── */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 37%, #f1f5f9 63%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
            border-radius: 6px;
        }
        .skeleton-text { height: 14px; margin-bottom: 8px; width: 80%; }
        .skeleton-title { height: 28px; margin-bottom: 12px; width: 60%; }
        .skeleton-circle { border-radius: 50%; }

        /* ── Toast Notifications ── */
        .toast-5psl {
            background: #fff; border-radius: 10px; padding: 16px 18px; margin-bottom: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12); border-left: 4px solid #ccc;
            animation: toastSlideIn 0.4s ease-out; transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .toast-5psl.toast-hiding { opacity: 0; transform: translateX(40px); }
        .toast-5psl-success { border-left-color: #059669; }
        .toast-5psl-error { border-left-color: #dc2626; }
        .toast-5psl-warning { border-left-color: #d97706; }
        .toast-5psl-info { border-left-color: #0066ff; }
        @keyframes toastSlideIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }

        /* ── Page Loader ── */
        .page-loader {
            position: fixed; inset: 0; background: white; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            transition: opacity 0.4s, visibility 0.4s;
        }
        .page-loader.loaded { opacity: 0; visibility: hidden; pointer-events: none; }
        .loader-spinner {
            width: 40px; height: 40px; border: 3px solid #e2e8f0;
            border-top-color: var(--possible-blue); border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Tier Badges ── */
        .tier-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px; font-size: 11px;
            font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px;
        }
        .tier-starter { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); color: #0284c7; border: 1px solid #bae6fd; }
        .tier-pro { background: linear-gradient(135deg, #fefce8, #fef9c3); color: #a16207; border: 1px solid #fde047; }
        .tier-elite { background: linear-gradient(135deg, #fdf4ff, #f5d0fe); color: #9333ea; border: 1px solid #d8b4fe; }

        /* ── Glass Card ── */
        .card-glass {
            background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3); border-radius: var(--radius-lg);
        }

        /* ── Gradient Cards ── */
        .card-gradient-blue { background: linear-gradient(135deg, #0066ff, #0047b3); color: white; border: none; }
        .card-gradient-dark { background: linear-gradient(135deg, #1e293b, #0f172a); color: white; border: none; }
        .card-gradient-green { background: linear-gradient(135deg, #059669, #047857); color: white; border: none; }

        /* ── Progress Bar ── */
        .progress-5psl { width: 100%; height: 6px; border-radius: 3px; background: #e2e8f0; overflow: hidden; }
        .progress-5psl-bar { height: 100%; border-radius: 3px; transition: width 1s ease-out; }
        .progress-5psl-blue { background: var(--possible-blue); }
        .progress-5psl-green { background: var(--color-success); }
        .progress-5psl-warning { background: var(--color-warning); }

        /* ── Crypto Styles ── */
        .crypto-address-box {
            background: #f8fafc; border: 1.5px dashed var(--color-border); border-radius: 8px;
            padding: 12px 16px; font-family: 'SF Mono', 'Fira Code', monospace; font-size: 12px;
            word-break: break-all; color: var(--possible-dark); position: relative;
            transition: border-color 0.2s;
        }
        .crypto-address-box:hover { border-color: var(--possible-blue); }
        .crypto-copy-btn {
            position: absolute; top: 8px; right: 8px; background: var(--possible-blue);
            color: white; border: none; border-radius: 5px; padding: 4px 10px;
            font-size: 10px; font-weight: 700; cursor: pointer; transition: all 0.2s;
        }
        .crypto-copy-btn:hover { transform: scale(1.05); }
        .crypto-copy-btn.copied { background: var(--color-success); }

        .network-pill {
            display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px;
            border-radius: 20px; border: 1.5px solid var(--color-border); background: white;
            font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s;
        }
        .network-pill:hover, .network-pill.active { border-color: var(--possible-blue); background: var(--possible-light-blue); color: var(--possible-blue); }

        /* ── Info Grid ── */
        .info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
        .info-item { padding: 14px 16px; background: #f8fafc; border-radius: 8px; }
        .info-item-label { font-size: 10px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-item-value { font-size: 15px; font-weight: 800; color: var(--possible-dark); }

        /* ── Tab Nav ── */
        .tab-nav-5psl { display: flex; gap: 4px; background: #f1f5f9; padding: 4px; border-radius: 8px; margin-bottom: 20px; }
        .tab-5psl {
            flex: 1; text-align: center; padding: 10px 16px; border-radius: 6px;
            font-size: 13px; font-weight: 700; color: var(--color-muted);
            cursor: pointer; transition: all 0.2s; border: none; background: transparent;
        }
        .tab-5psl.active { background: white; color: var(--possible-dark); box-shadow: 0 1px 3px rgba(0,0,0,0.08); }

        /* ── Responsive ── */
        @media(max-width:991px){
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { left: 0; padding: 0 16px; }
            .main-content { margin-left: 0; padding: calc(var(--topbar-h) + 20px) 16px 32px; }
            .mobile-toggle { display: block; }
            .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; }
            .overlay.active { display: block; }
            .section-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <div class="overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="/" style="text-decoration: none; color: white;"><span>5</span>PSL</a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Menu</div>
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Accueil
            </a>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                <div class="nav-section">Administration</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item" style="background: #059669; color: white; border-radius: 8px; margin: 0 12px; padding: 10px 14px; font-weight: 700;">
                    <i class="fas fa-shield-alt"></i> Espace Admin
                </a>
            @endif

            <div class="nav-section">Mon Espace</div>
            <a href="{{ route('investment.dashboard') }}" class="nav-item {{ request()->routeIs('investment.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Vue d'ensemble
            </a>
            <a href="{{ route('kyc.index') }}" class="nav-item {{ request()->routeIs('kyc.*') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Mon KYC
                @if(Auth::user()->kyc_status === 'verified')
                    <span style="color: var(--color-success); margin-left: auto;"><i class="fas fa-check-circle"></i></span>
                @elseif(Auth::user()->kyc_status === 'pending')
                    <span style="color: var(--color-warning); margin-left: auto;"><i class="fas fa-clock"></i></span>
                @elseif(Auth::user()->kyc_status === 'rejected')
                    <span style="color: var(--color-danger); margin-left: auto;"><i class="fas fa-times-circle"></i></span>
                @endif
            </a>
            <a href="{{ route('opportunities.index') }}" class="nav-item {{ request()->routeIs('opportunities.index') || request()->routeIs('opportunities.show') ? 'active' : '' }}">
                <i class="fas fa-lightbulb"></i> Opportunités
            </a>
            <a href="{{ route('investment.transaction.form') }}" class="nav-item {{ request()->routeIs('investment.transaction.*') ? 'active' : '' }}">
                <i class="fas fa-arrow-right-arrow-left"></i> Dépôts & Retraits
            </a>
            <a href="{{ route('affiliate.index') }}" class="nav-item {{ request()->routeIs('affiliate.*') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i> Affiliation
            </a>

            <div class="nav-section">Aide</div>
            <a href="{{ route('whitepaper') }}" class="nav-item {{ request()->routeIs('whitepaper') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Whitepaper
            </a>
            <a href="{{ route('support.index') }}" class="nav-item {{ request()->routeIs('support.*') ? 'active' : '' }}">
                <i class="fas fa-life-ring"></i> Assistance
                @php $myUnread = auth()->check() ? \App\Models\SupportTicket::where('user_id', auth()->id())->get()->sum(fn($t) => $t->unreadCountFor(auth()->user())) : 0; @endphp
                @if($myUnread > 0)
                    <span style="background: var(--possible-blue); color: white; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 10px; margin-left: auto;">{{ $myUnread }}</span>
                @endif
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
                    <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                        <span class="user-role">{{ Auth::user()->role === 'admin' ? 'Admin' : 'Membre' }}</span>
                        @php $userTier = Auth::user()->tier ?? 'STARTER'; @endphp
                        <span class="tier-badge tier-{{ strtolower($userTier) }}" style="padding: 2px 8px; font-size: 9px;">{{ $userTier }}</span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
            <h1 class="topbar-title">@yield('title')</h1>
        </div>
        
        <div class="topbar-right">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-topbar btn-topbar-outline">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Global Toast Notifications -->
        @if(session('success') || session('error') || session('warning') || session('info'))
        <div id="globalToastContainer" style="position:fixed;top:80px;right:20px;z-index:10000;max-width:420px;width:100%;">
          @if(session('success'))
          <div class="toast-5psl toast-5psl-success" role="alert">
            <div style="display:flex;align-items:flex-start;gap:12px;">
              <div style="width:32px;height:32px;border-radius:50%;background:#059669;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-check"></i>
              </div>
              <div style="flex:1;">
                <strong style="display:block;margin-bottom:2px;font-size:14px;">Succès</strong>
                <span style="font-size:13px;color:var(--color-muted);">{{ session('success') }}</span>
              </div>
              <button type="button" style="background:none;border:none;font-size:16px;color:var(--color-muted);cursor:pointer;padding:0;" onclick="this.closest('.toast-5psl').remove()">&times;</button>
            </div>
          </div>
          @endif
          @if(session('error'))
          <div class="toast-5psl toast-5psl-error" role="alert">
            <div style="display:flex;align-items:flex-start;gap:12px;">
              <div style="width:32px;height:32px;border-radius:50%;background:#dc2626;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-times"></i>
              </div>
              <div style="flex:1;">
                <strong style="display:block;margin-bottom:2px;font-size:14px;">Erreur</strong>
                <span style="font-size:13px;color:var(--color-muted);">{{ session('error') }}</span>
              </div>
              <button type="button" style="background:none;border:none;font-size:16px;color:var(--color-muted);cursor:pointer;padding:0;" onclick="this.closest('.toast-5psl').remove()">&times;</button>
            </div>
          </div>
          @endif
          @if(session('warning'))
          <div class="toast-5psl toast-5psl-warning" role="alert">
            <div style="display:flex;align-items:flex-start;gap:12px;">
              <div style="width:32px;height:32px;border-radius:50%;background:#d97706;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-exclamation-triangle"></i>
              </div>
              <div style="flex:1;">
                <strong style="display:block;margin-bottom:2px;font-size:14px;">Attention</strong>
                <span style="font-size:13px;color:var(--color-muted);">{{ session('warning') }}</span>
              </div>
              <button type="button" style="background:none;border:none;font-size:16px;color:var(--color-muted);cursor:pointer;padding:0;" onclick="this.closest('.toast-5psl').remove()">&times;</button>
            </div>
          </div>
          @endif
          @if(session('info'))
          <div class="toast-5psl toast-5psl-info" role="alert">
            <div style="display:flex;align-items:flex-start;gap:12px;">
              <div style="width:32px;height:32px;border-radius:50%;background:#0066ff;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-info"></i>
              </div>
              <div style="flex:1;">
                <strong style="display:block;margin-bottom:2px;font-size:14px;">Information</strong>
                <span style="font-size:13px;color:var(--color-muted);">{{ session('info') }}</span>
              </div>
              <button type="button" style="background:none;border:none;font-size:16px;color:var(--color-muted);cursor:pointer;padding:0;" onclick="this.closest('.toast-5psl').remove()">&times;</button>
            </div>
          </div>
          @endif
        </div>
        @endif
        @if($errors->any())
        <div id="globalToastContainer" style="position:fixed;top:80px;right:20px;z-index:10000;max-width:420px;width:100%;">
          <div class="toast-5psl toast-5psl-error" role="alert">
            <div style="display:flex;align-items:flex-start;gap:12px;">
              <div style="width:32px;height:32px;border-radius:50%;background:#dc2626;color:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-times"></i>
              </div>
              <div style="flex:1;">
                <strong style="display:block;margin-bottom:2px;font-size:14px;">Erreur de validation</strong>
                @foreach($errors->all() as $err)
                  <span style="font-size:13px;color:var(--color-muted);display:block;">• {{ $err }}</span>
                @endforeach
              </div>
              <button type="button" style="background:none;border:none;font-size:16px;color:var(--color-muted);cursor:pointer;padding:0;" onclick="this.closest('.toast-5psl').remove()">&times;</button>
            </div>
          </div>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Page loader
        window.addEventListener('load', function() {
            document.getElementById('pageLoader').classList.add('loaded');
        });
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('mobileToggle');
        function toggleSidebar() { sidebar.classList.toggle('open'); overlay.classList.toggle('active'); }
        if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);
        // Copy to clipboard helper
        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(function() {
                btn.textContent = '✓ Copié';
                btn.classList.add('copied');
                setTimeout(function() { btn.textContent = 'Copier'; btn.classList.remove('copied'); }, 2000);
            });
        }
    </script>
    <script>
        // Toast auto-dismiss
        document.querySelectorAll('.toast-5psl').forEach(function(toast) {
            setTimeout(function() {
                toast.classList.add('toast-hiding');
                setTimeout(function() { toast.remove(); }, 400);
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>
</html>
