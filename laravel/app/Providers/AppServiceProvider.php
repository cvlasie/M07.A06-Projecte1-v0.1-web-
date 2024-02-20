<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        URL::forceScheme('https');
        
        $currentLocale = session('locale', 'ca'); // 'ca' és l'idioma per defecte

        // Compartir aquesta variable amb totes les vistes
        View::share('currentLocale', $currentLocale);
    }
}
