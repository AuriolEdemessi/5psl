<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CourseController,
    SectionController,
    ChapterController,
    MediaController,
    QuizController,
    QuestionController,
    AdminController,
    AnswerController
};

// Group routes for admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Course Management
    Route::resource('courses', CourseController::class);

    // Section Management
    Route::resource('sections', SectionController::class);

    // Chapter Management
    Route::resource('chapters', ChapterController::class);

    // Media Management
    Route::resource('medias', MediaController::class);

    // Quiz Management
    Route::resource('quizzes', QuizController::class);

    // Question Management
    Route::resource('questions', QuestionController::class);

    // Answer Management
    Route::resource('answers', AnswerController::class);
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('lang/{lang}', [App\Http\Controllers\LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    

    Route::resource('courses', CourseController::class);

    // ===== Investment Club Routes =====

    // Dashboard investissement
    Route::get('/investment/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('investment.dashboard');

    // Investir
    Route::get('/investment/invest', [App\Http\Controllers\DashboardController::class, 'investForm'])->name('investment.invest.form');
    Route::post('/investment/invest', [App\Http\Controllers\DashboardController::class, 'invest'])->name('investment.invest');

    // Transactions (dépôt / retrait)
    Route::get('/investment/transaction', [App\Http\Controllers\DashboardController::class, 'transactionForm'])->name('investment.transaction.form');
    Route::post('/investment/transaction', [App\Http\Controllers\DashboardController::class, 'storeTransaction'])->name('investment.transaction.store');

    // Opportunités d'investissement (tous les membres)
    Route::get('/opportunities', [App\Http\Controllers\InvestmentOpportunityController::class, 'index'])->name('opportunities.index');
    Route::get('/opportunities/{opportunity}', [App\Http\Controllers\InvestmentOpportunityController::class, 'show'])->name('opportunities.show');
    Route::post('/opportunities/{opportunity}/vote', [App\Http\Controllers\InvestmentOpportunityController::class, 'vote'])->name('opportunities.vote');

    // Affiliation
    Route::get('/affiliation', [App\Http\Controllers\DashboardController::class, 'affiliate'])->name('affiliate.index');

    // KYC (Membre)
    Route::get('/kyc', [App\Http\Controllers\KycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc', [App\Http\Controllers\KycController::class, 'store'])->name('kyc.store');

    // Whitepaper
    Route::get('/whitepaper', function () { return view('whitepaper'); })->name('whitepaper');

    // ===== Support / Assistance (membre) =====
    Route::get('/support', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [App\Http\Controllers\SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [App\Http\Controllers\SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/reply', [App\Http\Controllers\SupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [App\Http\Controllers\SupportController::class, 'close'])->name('support.close');

    // ===== Support / Admin =====
    Route::get('/admin/support', [App\Http\Controllers\Admin\AdminSupportController::class, 'index'])->name('admin.support.index');
    Route::get('/admin/support/{ticket}', [App\Http\Controllers\Admin\AdminSupportController::class, 'show'])->name('admin.support.show');
    Route::post('/admin/support/{ticket}/reply', [App\Http\Controllers\Admin\AdminSupportController::class, 'reply'])->name('admin.support.reply');
    Route::post('/admin/support/{ticket}/assign', [App\Http\Controllers\Admin\AdminSupportController::class, 'assign'])->name('admin.support.assign');

    // ===== KYC / Admin =====
    Route::get('/admin/kyc', [App\Http\Controllers\Admin\AdminKycController::class, 'index'])->name('admin.kyc.index');
    Route::get('/admin/kyc/{user}', [App\Http\Controllers\Admin\AdminKycController::class, 'show'])->name('admin.kyc.show');
    Route::post('/admin/kyc/{user}/verify', [App\Http\Controllers\Admin\AdminKycController::class, 'verify'])->name('admin.kyc.verify');
    Route::post('/admin/kyc/{user}/reject', [App\Http\Controllers\Admin\AdminKycController::class, 'reject'])->name('admin.kyc.reject');
    Route::get('/admin/kyc/download/{document}', [App\Http\Controllers\Admin\AdminKycController::class, 'download'])->name('admin.kyc.download');

    // Création d'opportunités (admin uniquement)
    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/opportunities/create/new', [App\Http\Controllers\InvestmentOpportunityController::class, 'create'])->name('opportunities.create');
        Route::post('/opportunities', [App\Http\Controllers\InvestmentOpportunityController::class, 'store'])->name('opportunities.store');
        
        // Administration Investissement (KYC, Transactions)
        Route::get('/investment/admin', [App\Http\Controllers\AdminInvestmentController::class, 'index'])->name('investment.admin.index');
        Route::post('/investment/admin/kyc/{user}/approve', [App\Http\Controllers\AdminInvestmentController::class, 'approveKyc'])->name('admin.kyc.approve');
        Route::post('/investment/admin/kyc/{user}/reject', [App\Http\Controllers\AdminInvestmentController::class, 'rejectKyc'])->name('admin.kyc.reject');
        Route::post('/investment/admin/transactions/{transaction}/approve', [App\Http\Controllers\AdminInvestmentController::class, 'approveTransaction'])->name('admin.transactions.approve');
        Route::post('/investment/admin/transactions/{transaction}/reject', [App\Http\Controllers\AdminInvestmentController::class, 'rejectTransaction'])->name('admin.transactions.reject');

        // Admin : Gestion Utilisateurs
        Route::get('/admin/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('admin.users.update');

        // Admin : Gestion Portefeuilles Centraux (12 words)
        Route::get('/admin/wallets', [App\Http\Controllers\Admin\ClubWalletController::class, 'index'])->name('admin.wallets.index');
        Route::get('/admin/wallets/create', [App\Http\Controllers\Admin\ClubWalletController::class, 'create'])->name('admin.wallets.create');
        Route::post('/admin/wallets', [App\Http\Controllers\Admin\ClubWalletController::class, 'store'])->name('admin.wallets.store');
        Route::get('/admin/wallets/{wallet}/edit', [App\Http\Controllers\Admin\ClubWalletController::class, 'edit'])->name('admin.wallets.edit');
        Route::put('/admin/wallets/{wallet}', [App\Http\Controllers\Admin\ClubWalletController::class, 'update'])->name('admin.wallets.update');
        Route::delete('/admin/wallets/{wallet}', [App\Http\Controllers\Admin\ClubWalletController::class, 'destroy'])->name('admin.wallets.destroy');

        // Admin : Gestion adresses crypto (dépôts membres)
        Route::get('/investment/admin/crypto-addresses', [App\Http\Controllers\AdminCryptoAddressController::class, 'index'])->name('admin.crypto.index');
        Route::post('/investment/admin/crypto-addresses', [App\Http\Controllers\AdminCryptoAddressController::class, 'store'])->name('admin.crypto.store');
        Route::put('/investment/admin/crypto-addresses/{cryptoAddress}', [App\Http\Controllers\AdminCryptoAddressController::class, 'update'])->name('admin.crypto.update');
        Route::post('/investment/admin/crypto-addresses/{cryptoAddress}/toggle', [App\Http\Controllers\AdminCryptoAddressController::class, 'toggleActive'])->name('admin.crypto.toggle');
        Route::delete('/investment/admin/crypto-addresses/{cryptoAddress}', [App\Http\Controllers\AdminCryptoAddressController::class, 'destroy'])->name('admin.crypto.destroy');

        // Admin : Support / Assistance
        Route::get('/investment/admin/support', [App\Http\Controllers\AdminSupportController::class, 'index'])->name('admin.support.index');
        Route::post('/investment/admin/support/{ticket}/assign', [App\Http\Controllers\AdminSupportController::class, 'assign'])->name('admin.support.assign');
        Route::post('/investment/admin/support/{ticket}/status', [App\Http\Controllers\AdminSupportController::class, 'updateStatus'])->name('admin.support.status');
    });

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
