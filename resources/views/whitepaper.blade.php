@extends('layouts.dashboard')
@section('title', 'Whitepaper')

@section('content')

<style>
    .wp-container { max-width: 860px; margin: 0 auto; }
    .wp-hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0066ff 100%); border-radius: 16px; padding: 48px 40px; color: white; margin-bottom: 32px; position: relative; overflow: hidden; }
    .wp-hero::before { content: ''; position: absolute; top: -50%; right: -30%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(0,102,255,0.2), transparent 70%); border-radius: 50%; }
    .wp-hero h1 { font-size: 32px; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px; position: relative; }
    .wp-hero p { font-size: 15px; opacity: 0.7; max-width: 600px; line-height: 1.6; position: relative; }
    .wp-section { margin-bottom: 36px; }
    .wp-section-num { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); font-weight: 900; font-size: 14px; margin-right: 12px; flex-shrink: 0; }
    .wp-section h2 { font-size: 20px; font-weight: 900; color: var(--possible-dark); display: flex; align-items: center; margin-bottom: 16px; }
    .wp-section p { font-size: 14px; line-height: 1.9; color: #475569; margin-bottom: 12px; }
    .wp-highlight { background: #f8fafc; border-left: 4px solid var(--possible-blue); padding: 20px 24px; border-radius: 0 10px 10px 0; margin: 16px 0; }
    .wp-highlight p { margin: 0; font-weight: 600; font-size: 13px; color: var(--possible-dark); }
    .wp-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin: 16px 0; }
    .wp-grid-item { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; }
    .wp-grid-item .wp-gi-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 20px; }
    .wp-grid-item h4 { font-size: 14px; font-weight: 800; margin-bottom: 4px; }
    .wp-grid-item p { font-size: 12px; color: #64748b; margin: 0; line-height: 1.5; }
    .wp-alloc-bar { display: flex; border-radius: 8px; overflow: hidden; height: 14px; margin: 12px 0; }
    .wp-toc { list-style: none; padding: 0; margin: 0; }
    .wp-toc li { padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
    .wp-toc li a { text-decoration: none; color: var(--possible-dark); font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px; }
    .wp-toc li a:hover { color: var(--possible-blue); }
    @media (max-width: 768px) { .wp-grid { grid-template-columns: 1fr; } .wp-hero { padding: 32px 24px; } }
</style>

<div class="wp-container">

    {{-- Hero --}}
    <div class="wp-hero animate-fade-in-up">
        <h1>Whitepaper 5PSL</h1>
        <p>Le Modèle Opérationnel du Club d'Investissement 5PSL — Transparence, Rigueur et Performance.</p>
        <div style="display: flex; gap: 12px; margin-top: 20px; position: relative;">
            <span style="background: rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 6px; font-size: 11px; font-weight: 700;">v1.0</span>
            <span style="background: rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 6px; font-size: 11px; font-weight: 700;">Mars 2026</span>
            <span style="background: rgba(255,255,255,0.15); padding: 6px 14px; border-radius: 6px; font-size: 11px; font-weight: 700;">Laravel NAV-Based</span>
        </div>
    </div>

    {{-- Table of contents --}}
    <div class="card-5psl mb-4 animate-fade-in-up delay-1">
        <h4 style="font-size: 14px; font-weight: 800; margin-bottom: 12px;"><i class="fas fa-list me-2" style="color: var(--possible-blue);"></i>Sommaire</h4>
        <ul class="wp-toc">
            <li><a href="#s1"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">I</span> Introduction et Vision Stratégique</a></li>
            <li><a href="#s2"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">II</span> Structure des Membres et Hiérarchie des Paliers</a></li>
            <li><a href="#s3"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">III</span> Le Moteur Financier : Valeur Liquidative et Parts</a></li>
            <li><a href="#s4"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">IV</span> La Stratégie d'Allocation 50/30/20</a></li>
            <li><a href="#s5"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">V</span> Modèle de Performance et Règle du Sommet Historique</a></li>
            <li><a href="#s6"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">VI</span> Distribution des Profits et Retraits Mensuels</a></li>
            <li><a href="#s7"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">VII</span> Affiliation et Croissance Organique</a></li>
            <li><a href="#s8"><span class="wp-section-num" style="width: 22px; height: 22px; font-size: 11px; margin-right: 8px;">VIII</span> Transparence, Sécurité et Gestion des Risques</a></li>
        </ul>
    </div>

    {{-- Section I --}}
    <div class="wp-section card-5psl animate-fade-in-up delay-2" id="s1">
        <h2><span class="wp-section-num">I</span> Introduction et Vision Stratégique</h2>
        <p>Le projet 5PSL naît d'une volonté de démocratiser l'investissement de groupe en s'appuyant sur la rigueur technologique. Plutôt que de laisser des capitaux dormir ou de s'exposer seul à des marchés complexes, 5PSL propose une structure de club privé où la confiance mutuelle est renforcée par un système de gestion automatisé sous Laravel.</p>
        <p>L'objectif est double : protéger le patrimoine des membres tout en capturant des opportunités de croissance à travers une gestion disciplinée et transparente.</p>
        <div class="wp-highlight">
            <p><i class="fas fa-quote-left me-2" style="color: var(--possible-blue);"></i>La technologie au service de la confiance — chaque transaction, chaque calcul est auditable et traçable.</p>
        </div>
    </div>

    {{-- Section II --}}
    <div class="wp-section card-5psl animate-fade-in-up delay-3" id="s2">
        <h2><span class="wp-section-num">II</span> Structure des Membres et Hiérarchie des Paliers</h2>
        <p>L'écosystème 5PSL s'organise autour de trois statuts distincts qui reflètent l'engagement financier de chaque participant :</p>
        <div class="wp-grid">
            <div class="wp-grid-item">
                <div class="wp-gi-icon" style="background: #f1f5f9; color: #64748b;"><i class="fas fa-seedling"></i></div>
                <h4>Starter</h4>
                <p>$500 — $2 500</p>
                <div style="font-size: 20px; font-weight: 900; color: var(--possible-dark); margin-top: 4px;">$20<span style="font-size: 11px; font-weight: 600; color: #94a3b8;">/an</span></div>
            </div>
            <div class="wp-grid-item" style="border-color: var(--possible-blue);">
                <div class="wp-gi-icon" style="background: rgba(0,102,255,0.08); color: var(--possible-blue);"><i class="fas fa-rocket"></i></div>
                <h4>Pro</h4>
                <p>$2 500 — $10 000</p>
                <div style="font-size: 20px; font-weight: 900; color: var(--possible-dark); margin-top: 4px;">$50<span style="font-size: 11px; font-weight: 600; color: #94a3b8;">/an</span></div>
            </div>
            <div class="wp-grid-item" style="border-color: #f59e0b;">
                <div class="wp-gi-icon" style="background: #fffbeb; color: #f59e0b;"><i class="fas fa-crown"></i></div>
                <h4>Elite</h4>
                <p>$10 000+</p>
                <div style="font-size: 20px; font-weight: 900; color: var(--possible-dark); margin-top: 4px;">$100<span style="font-size: 11px; font-weight: 600; color: #94a3b8;">/an</span></div>
            </div>
        </div>
        <p>Cette segmentation permet d'adapter les services et le support tout en finançant la maintenance technique de la plateforme de manière équitable.</p>
    </div>

    {{-- Section III --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s3">
        <h2><span class="wp-section-num">III</span> Le Moteur Financier : Valeur Liquidative et Parts</h2>
        <p>Pour assurer une équité mathématique parfaite, 5PSL fonctionne selon le principe de la Valeur Liquidative (NAV). À chaque fois qu'un membre dépose des fonds, il n'achète pas une somme fixe, mais des <strong>"parts"</strong> du club.</p>
        <p>Si le club performe et que la valeur des actifs augmente, le prix de la part monte. Ainsi, un membre entrant tardivement paiera sa part plus cher que le membre fondateur, protégeant ainsi les profits de ceux qui étaient là depuis le début.</p>
        <div class="wp-highlight">
            <p><i class="fas fa-calculator me-2" style="color: var(--possible-blue);"></i><strong>NAV = Total des Actifs Réels / Nombre de Parts en Circulation</strong></p>
            <p style="margin-top: 8px; font-weight: 400; color: #64748b;">NAV initiale fixée à $10.00 — Calcul rafraîchi en temps réel avec bcmath (8 décimales de précision).</p>
        </div>
    </div>

    {{-- Section IV --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s4">
        <h2><span class="wp-section-num">IV</span> La Stratégie d'Allocation 50/30/20</h2>
        <p>La résilience de 5PSL repose sur une répartition stricte du capital global, baptisée <strong>règle 50/30/20</strong> :</p>
        <div class="wp-alloc-bar">
            <div style="width: 50%; background: #0066ff;" title="Sécurité 50%"></div>
            <div style="width: 30%; background: #059669;" title="Croissance 30%"></div>
            <div style="width: 20%; background: #f59e0b;" title="Opportunité 20%"></div>
        </div>
        <div class="row g-3" style="margin-top: 4px;">
            <div class="col-md-4">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #0066ff;"></div>
                    <strong style="font-size: 13px;">50% Sécurité</strong>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0;">Bons du Trésor, dépôts à terme — préservation du socle financier.</p>
            </div>
            <div class="col-md-4">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #059669;"></div>
                    <strong style="font-size: 13px;">30% Croissance</strong>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0;">Actions à dividendes, indices boursiers — plus-value stable.</p>
            </div>
            <div class="col-md-4">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #f59e0b;"></div>
                    <strong style="font-size: 13px;">20% Opportunité</strong>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0;">Cryptomonnaies, startups — dynamisation du rendement.</p>
            </div>
        </div>
        <p style="margin-top: 16px;">Cette diversification protège le club contre l'effondrement d'un secteur spécifique.</p>
    </div>

    {{-- Section V --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s5">
        <h2><span class="wp-section-num">V</span> Modèle de Performance et Règle du Sommet Historique</h2>
        <p>Le modèle économique de 5PSL est conçu pour aligner les intérêts du gestionnaire avec ceux des investisseurs.</p>
        <div class="row g-3" style="margin: 16px 0;">
            <div class="col-md-6">
                <div style="background: #f8fafc; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 8px;">Frais d'entrée</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--possible-dark);">2%</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Couvrent les coûts opérationnels à chaque dépôt.</div>
                </div>
            </div>
            <div class="col-md-6">
                <div style="background: #f8fafc; border-radius: 10px; padding: 20px; border: 1px solid #e2e8f0;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 8px;">Commission de performance</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--possible-dark);">30%</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Uniquement sur les plus-values au-dessus du sommet historique.</div>
                </div>
            </div>
        </div>
        <div class="wp-highlight">
            <p><i class="fas fa-mountain me-2" style="color: var(--possible-blue);"></i><strong>High-Water Mark :</strong> Aucun frais n'est prélevé tant que l'investisseur n'a pas dépassé son point le plus haut historique. Si le portefeuille subit une baisse, le gestionnaire ne perçoit aucune commission de performance tant que les pertes ne sont pas totalement effacées.</p>
        </div>
    </div>

    {{-- Section VI --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s6">
        <h2><span class="wp-section-num">VI</span> Distribution des Profits et Retraits Mensuels</h2>
        <p>Contrairement aux fonds bloqués traditionnels, 5PSL permet une <strong>liquidité mensuelle</strong>. Tous les 30 jours, les membres peuvent choisir de retirer la portion de leur capital correspondant à la plus-value nette générée sur la période.</p>
        <p>Ce système permet aux investisseurs de bénéficier d'un revenu passif régulier tout en laissant leur capital initial travailler.</p>
        <div class="wp-highlight">
            <p><i class="fas fa-sync me-2" style="color: #059669;"></i><strong>Intérêts composés :</strong> Si un membre choisit de ne pas retirer ses profits, ceux-ci sont automatiquement réinvestis, activant ainsi le levier des intérêts composés pour accélérer la croissance de son patrimoine.</p>
        </div>
    </div>

    {{-- Section VII --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s7">
        <h2><span class="wp-section-num">VII</span> Affiliation et Croissance Organique</h2>
        <p>La plateforme intègre un programme d'affiliation basé sur le partage de revenus. Lorsqu'un membre parraine un nouvel investisseur, il reçoit <strong>10% de la commission de performance</strong> perçue par le gestionnaire sur ce filleul.</p>
        <div style="background: linear-gradient(135deg, #ecfdf5, #f0fdf4); border: 1px solid #a7f3d0; border-radius: 12px; padding: 20px; margin: 16px 0; display: flex; align-items: center; gap: 16px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #059669; color: white; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fas fa-handshake"></i>
            </div>
            <div>
                <div style="font-size: 14px; font-weight: 800; color: #065f46;">Système vertueux</div>
                <div style="font-size: 12px; color: #047857; line-height: 1.6;">La récompense provient de la part du gestionnaire — elle ne coûte rien au club ni au filleul. Cela incite les parrains à accompagner leurs filleuls sur le long terme et à attirer des capitaux de qualité.</div>
            </div>
        </div>
    </div>

    {{-- Section VIII --}}
    <div class="wp-section card-5psl animate-fade-in-up" id="s8">
        <h2><span class="wp-section-num">VIII</span> Transparence, Sécurité et Gestion des Risques</h2>
        <p>La sécurité des données et des fonds est la priorité absolue. Grâce aux Policies de Laravel, chaque membre ne peut accéder qu'à ses propres statistiques et son historique, assurant une confidentialité totale au sein du groupe.</p>
        <p>En cas de récession des marchés, 5PSL utilise des outils de monitoring pour informer les membres en toute transparence.</p>
        <div class="row g-3" style="margin: 16px 0;">
            <div class="col-md-4">
                <div style="text-align: center; padding: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 18px;"><i class="fas fa-shield-alt"></i></div>
                    <h4 style="font-size: 13px; font-weight: 800;">Policies Laravel</h4>
                    <p style="font-size: 11px; color: #64748b; margin: 0;">Accès restreint aux données personnelles uniquement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 18px;"><i class="fas fa-piggy-bank"></i></div>
                    <h4 style="font-size: 13px; font-weight: 800;">Réserve de liquidité</h4>
                    <p style="font-size: 11px; color: #64748b; margin: 0;">50% en sécurité garantit les retraits en toute circonstance.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div style="text-align: center; padding: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 18px;"><i class="fas fa-balance-scale"></i></div>
                    <h4 style="font-size: 13px; font-weight: 800;">Rééquilibrage</h4>
                    <p style="font-size: 11px; color: #64748b; margin: 0;">Rachat d'opportunités à bas prix durant les crises.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="card-5psl card-gradient-dark animate-fade-in-up" style="text-align: center; padding: 32px;">
        <div style="font-size: 24px; font-weight: 900; margin-bottom: 8px;">5PSL</div>
        <p style="font-size: 13px; opacity: 0.6; max-width: 500px; margin: 0 auto;">Investir ensemble, grandir ensemble. La technologie au service de la transparence financière.</p>
        <div style="margin-top: 16px; font-size: 11px; opacity: 0.3;">Whitepaper v1.0 — Mars 2026</div>
    </div>

</div>

@endsection
