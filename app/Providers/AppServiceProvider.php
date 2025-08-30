<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\ConfigSystem;

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
        $version = time();
        $serverName = '127.0.0.1';
        $ip = request()->ip();
        $online = '127.0.0.1';
        view()->share('version', $version);
        view()->share('serverName', $serverName);
        view()->share('ip', $ip);
        view()->share('online', $online);
        if (Schema::hasTable('config_systems')) {
            $config = ConfigSystem::all();
            foreach ($config as $item) {
                if (!config($item->key)) {
                    config([$item->key => $item->value]);
                }
            }
        }
    }
}
