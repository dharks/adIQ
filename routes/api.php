<?php

use App\Http\Controllers\Api\GamController;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\PluginController;
use App\Http\Controllers\Api\SubdomainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api automatically by Laravel.
| The WordPress plugin calls these endpoints using the license key.
|
*/

Route::prefix('v1')->group(function () {

    // License management
    Route::post('/activate', [LicenseController::class, 'activate']);
    Route::post('/deactivate', [LicenseController::class, 'deactivate']);
    Route::get('/verify', [LicenseController::class, 'verify']);

    // Plugin update & download
    Route::get('/plugin/version',  [PluginController::class, 'version']);
    Route::get('/plugin/download', [PluginController::class, 'download']);

    // Protected endpoints - require valid, domain-verified license key
    Route::middleware('license.valid')->group(function () {
        // GAM proxy
        Route::get('/gam/adunits',             [GamController::class, 'adUnits']);
        Route::get('/gam/adunit',              [GamController::class, 'adUnit']);
        Route::post('/gam/revoke',             [GamController::class, 'revoke']);
        Route::post('/gam/setup-keyvalues',    [GamController::class, 'setupKeyValues']);

        // Subdomain management (called from plugin Settings page)
        Route::get('/subdomains',              [SubdomainController::class, 'index']);
        Route::post('/subdomains',             [SubdomainController::class, 'store']);
        Route::delete('/subdomains/{subdomain}', [SubdomainController::class, 'destroy']);
    });
});
