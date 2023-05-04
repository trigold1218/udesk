<?php

namespace Trigold\Udesk;

use Trigold\Udesk\Laravel\Manager\CrmManager;
use Trigold\Udesk\Laravel\Manager\CcpsManager;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class UdeskServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/udesk.php', 'udesk');

        $this->app->singleton('udesk.ccps', function () {
            return new CcpsManager($this->app);
        });

        $this->app->singleton('udesk.crm', function () {
            return new CrmManager($this->app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => $this->app->basePath('config')], 'config');
        }
    }

    public function provides(): array
    {
        return ['udesk.ccps', 'udesk.crm'];
    }
}
