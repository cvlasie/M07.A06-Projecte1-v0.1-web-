<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Filament\Resources\VisibilityResource;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function getNavigation(): array
    {
        return [
            // Altres elements del menú...

            Filament::makeNavigationItem()
                ->label('Visibilities')
                ->url(VisibilityResource::getUrl('index'))
                ->icon('heroicon-o-eye'),
        ];
    }
}
