<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Mensuel 5PSL</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-radius: 12px 12px 0 0; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">📊 Rapport Mensuel</h1>
            <p style="color: #94a3b8; margin: 8px 0 0 0; font-size: 14px;">{{ $reportDate }}</p>
        </div>

        <!-- Content -->
        <div style="background: #ffffff; padding: 30px; border-radius: 0 0 12px 12px;">

            <p style="color: #334155; font-size: 16px; margin-bottom: 24px;">
                Bonjour <strong>{{ $userName }}</strong>,<br>
                Voici le récapitulatif de vos performances pour le mois écoulé.
            </p>

            <!-- Stats Cards -->
            <div style="margin-bottom: 24px;">
                <!-- Portefeuille -->
                <div style="background: #f0fdf4; border-radius: 8px; padding: 16px; margin-bottom: 12px; border-left: 4px solid #10B981;">
                    <p style="margin: 0 0 4px 0; color: #64748b; font-size: 12px; text-transform: uppercase;">Valeur du Portefeuille</p>
                    <p style="margin: 0; color: #1a1a2e; font-size: 22px; font-weight: bold;">{{ $portfolioValue }} FCFA</p>
                </div>

                <!-- Solde -->
                <div style="background: #fffbeb; border-radius: 8px; padding: 16px; margin-bottom: 12px; border-left: 4px solid #F59E0B;">
                    <p style="margin: 0 0 4px 0; color: #64748b; font-size: 12px; text-transform: uppercase;">Solde Disponible</p>
                    <p style="margin: 0; color: #1a1a2e; font-size: 22px; font-weight: bold;">{{ $solde }} FCFA</p>
                </div>

                <!-- ROI -->
                <div style="background: {{ (float)str_replace(',', '.', $roi) >= 0 ? '#f0fdf4' : '#fef2f2' }}; border-radius: 8px; padding: 16px; margin-bottom: 12px; border-left: 4px solid {{ (float)str_replace(',', '.', $roi) >= 0 ? '#10B981' : '#EF4444' }};">
                    <p style="margin: 0 0 4px 0; color: #64748b; font-size: 12px; text-transform: uppercase;">Performance (ROI)</p>
                    <p style="margin: 0; color: {{ (float)str_replace(',', '.', $roi) >= 0 ? '#10B981' : '#EF4444' }}; font-size: 22px; font-weight: bold;">
                        {{ (float)str_replace(',', '.', $roi) >= 0 ? '↑' : '↓' }} {{ $roi }}%
                    </p>
                </div>

                <!-- NAV -->
                <div style="background: #eef2ff; border-radius: 8px; padding: 16px; border-left: 4px solid #6366F1;">
                    <p style="margin: 0 0 4px 0; color: #64748b; font-size: 12px; text-transform: uppercase;">Valeur d'une Part (NAV)</p>
                    <p style="margin: 0; color: #1a1a2e; font-size: 22px; font-weight: bold;">{{ $nav }} FCFA</p>
                </div>
            </div>

            <!-- Dernières transactions -->
            @if(count($recentTransactions) > 0)
                <h3 style="color: #1a1a2e; font-size: 16px; margin-bottom: 12px;">Dernières Transactions</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 10px; text-align: left; color: #64748b; border-bottom: 1px solid #e2e8f0;">Date</th>
                            <th style="padding: 10px; text-align: left; color: #64748b; border-bottom: 1px solid #e2e8f0;">Type</th>
                            <th style="padding: 10px; text-align: right; color: #64748b; border-bottom: 1px solid #e2e8f0;">Montant</th>
                            <th style="padding: 10px; text-align: center; color: #64748b; border-bottom: 1px solid #e2e8f0;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $tx)
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155;">{{ $tx['date'] }}</td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                    <span style="color: {{ $tx['type'] === 'depot' ? '#10B981' : '#EF4444' }}; font-weight: 600;">
                                        {{ $tx['type'] === 'depot' ? '↓ Dépôt' : '↑ Retrait' }}
                                    </span>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: right; font-weight: bold; color: #1a1a2e;">{{ $tx['montant'] }} FCFA</td>
                                <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                    <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px;
                                        @if($tx['statut'] === 'approuve') background: #dcfce7; color: #16a34a;
                                        @elseif($tx['statut'] === 'en_attente') background: #fef3c7; color: #d97706;
                                        @else background: #fee2e2; color: #dc2626;
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $tx['statut'])) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <!-- CTA -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/investment/dashboard') }}" style="display: inline-block; background: #10B981; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                    Accéder à mon Dashboard
                </a>
            </div>

            <!-- Footer -->
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center;">
                <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                    Ce rapport est généré automatiquement par la plateforme 5PSL.<br>
                    &copy; {{ date('Y') }} 5PSL - Club d'Investissement
                </p>
            </div>

        </div>
    </div>
</body>
</html>
