<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\GamOAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page — authenticated users get pushed to dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');

// Legal pages
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// SEO
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'),           'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => url('/privacy'),    'priority' => '0.3', 'changefreq' => 'yearly'],
        ['loc' => url('/terms'),      'priority' => '0.3', 'changefreq' => 'yearly'],
        ['loc' => url('/register'),   'priority' => '0.8', 'changefreq' => 'monthly'],
        ['loc' => url('/login'),      'priority' => '0.6', 'changefreq' => 'monthly'],
    ];
    return response()->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nDisallow: /dashboard\nDisallow: /admin\nDisallow: /oauth\n\nSitemap: " . url('/sitemap.xml'),
        200
    )->header('Content-Type', 'text/plain');
});

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/sites', [DashboardController::class, 'addSite'])->name('sites.add');
    Route::delete('/sites/{site}', [DashboardController::class, 'deleteSite'])->name('sites.delete');

    // Site detail & subdomain management
    Route::get('/sites/{site}', [DashboardController::class, 'showSite'])->name('sites.show');
    Route::post('/sites/{site}/subdomains', [DashboardController::class, 'addSubdomain'])->name('sites.subdomains.add');
    Route::delete('/sites/{site}/subdomains/{subdomain}', [DashboardController::class, 'deleteSubdomain'])->name('sites.subdomains.delete');
});

// Super-admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/sites/{site}', [AdminController::class, 'show'])->name('sites.show');
    Route::post('/sites/{site}/suspend', [AdminController::class, 'suspend'])->name('sites.suspend');
    Route::delete('/sites/{site}', [AdminController::class, 'destroy'])->name('sites.destroy');
    Route::post('/sites/{site}/note', [AdminController::class, 'updateNote'])->name('sites.note');
});

// OAuth callback routes (session-based, no auth middleware — Google redirects here)
Route::get('/oauth/gam/init', [GamOAuthController::class, 'init'])->name('gam.oauth.init');
Route::get('/oauth/gam/callback', [GamOAuthController::class, 'callback'])->name('gam.oauth.callback');
Route::post('/oauth/gam/select-network', [GamOAuthController::class, 'selectNetwork'])->name('gam.oauth.select-network');
