<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Offre;
use App\Models\Commission;
use Inertia\Inertia;

class AdminController extends Controller
{
  public function index()
{
    $totalUsers = Utilisateur::count();
    $totalOffers = Offre::count();
    $totalCommissions = Commission::sum('amount');
    $activeUsers = Utilisateur::where('status', true)->count();
    $monthlyUsers = Utilisateur::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Ajout des activités récentes
    $recentActivities = [
        'newUsers' => Utilisateur::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user',
                    'message' => 'Nouvel utilisateur inscrit',
                    'time' => $user->created_at->diffForHumans(),
                    'name' => $user->name
                ];
            }),
        'newCommissions' => Commission::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($commission) {
                return [
                    'type' => 'commission',
                    'message' => 'Nouvelle commission reçue',
                    'time' => $commission->created_at->diffForHumans(),
                    'amount' => $commission->amount
                ];
            }),
        'newOffers' => Offre::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($offer) {
                return [
                    'type' => 'offer',
                    'message' => 'Nouvelle offre soumise',
                    'time' => $offer->created_at->diffForHumans(),
                    'title' => $offer->title
                ];
            })
    ];

    return Inertia::render('admin/Dashboard', [
        'stats' => [
            'totalUsers' => $totalUsers,
            'totalOffers' => $totalOffers,
            'totalCommissions' => (float) $totalCommissions,
            'activeUsers' => $activeUsers,
        ],
        'charts' => [
            'monthlyUsers' => $monthlyUsers,
        ],
        'recentActivities' => $recentActivities
    ]);
}
    public function getApiStats()
    {
        try {
            // Récupérer les statistiques réelles depuis la base de données
            $totalUsers = Utilisateur::count();
            $totalOffers = Offre::count();
            $totalCommissions = Commission::sum('amount') ?? 0;
            $activeUsers = Utilisateur::where('status', 'true')->count();
             $activeUsers = Utilisateur::where('status', true)->count();
  
            // Récupérer les utilisateurs par mois pour les graphiques
            $monthlyUsers = Utilisateur::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
                
             // Récupérer les commissions par mois pour les graphiques
        $monthlyCommissions = Commission::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calcul de la croissance des commissions par rapport au mois précédent
        $previousMonthCommissions = Commission::selectRaw('SUM(amount) as total')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('n') - 1)  // Mois précédent
            ->first();

        $growthRate = 0;
        if ($previousMonthCommissions && $previousMonthCommissions->total > 0) {
            $growthRate = (($totalCommissions - $previousMonthCommissions->total) / $previousMonthCommissions->total) * 100;
        }

        // Ajout des activités récentes
    $recentActivities = [
        'newUsers' => Utilisateur::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'user',
                    'message' => 'Nouvel utilisateur inscrit',
                    'time' => $user->created_at->diffForHumans(),
                    'name' => $user->name
                ];
            }),
        'newCommissions' => Commission::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($commission) {
                return [
                    'type' => 'commission',
                    'message' => 'Nouvelle commission reçue',
                    'time' => $commission->created_at->diffForHumans(),
                    'amount' => $commission->amount
                ];
            }),
        'newOffers' => Offre::orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($offer) {
                return [
                    'type' => 'offer',
                    'message' => 'Nouvelle offre soumise',
                    'time' => $offer->created_at ? $offer->created_at->diffForHumans() : 'Date inconnue',                    
                    'title' => $offer->title
                ];
            })
    ];
            // Renvoyer les données sous format JSON
            return response()->json([
                'success' => true,
                'data' => [
                    'stats' => [
                        'totalUsers' => $totalUsers,
                        'totalOffers' => $totalOffers,
                        'totalCommissions' => $totalCommissions,
                        'activeUsers' => $activeUsers,
                         'growthRate' => round($growthRate, 2) // Ajoutez ici la croissance
                    ],
                    'charts' => [
                        'monthlyUsers' => $monthlyUsers,
                        'monthlyCommissions' => $monthlyCommissions,  // Données des commissions par mois
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des données'
            ]);
        }
    }
}
