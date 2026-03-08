<?php

use Illuminate\Support\Facades\Route;
use Webkul\Asaas\Http\Controllers\AsaasController;
use Webkul\Asaas\Http\Controllers\BoletoController;
use Webkul\Asaas\Http\Controllers\CardController;
use Webkul\Asaas\Http\Controllers\PixController;

Route::group(['middleware' => ['web']], function () {
    Route::prefix('asaas')->group(function () {
        Route::prefix('pix')->group(function () {
            Route::get('/redirect', [PixController::class, 'redirect'])
                ->name('asaas.pix.redirect');
            Route::post('/status', [PixController::class, 'checkStatus'])
                ->name('asaas.pix.status');
        });

        Route::prefix('pix-copy-paste')->group(function () {
            Route::get('/redirect', [PixController::class, 'redirect'])
                ->name('asaas.pix-copy-paste.redirect');
        });

        Route::prefix('boleto')->group(function () {
            Route::get('/redirect', [BoletoController::class, 'redirect'])
                ->name('asaas.boleto.redirect');
            Route::get('/print', [BoletoController::class, 'printBoleto'])
                ->name('asaas.boleto.print');
        });

        Route::prefix('card')->group(function () {
            Route::get('/redirect', [CardController::class, 'redirect'])
                ->name('asaas.card.redirect');
            Route::post('/process', [CardController::class, 'process'])
                ->name('asaas.card.process');
        });

        Route::get('/success', [AsaasController::class, 'success'])
            ->name('asaas.success');
        Route::get('/cancel', [AsaasController::class, 'cancel'])
            ->name('asaas.cancel');

        Route::post('/webhook', [AsaasController::class, 'webhook'])
            ->name('asaas.webhook')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    });
});
