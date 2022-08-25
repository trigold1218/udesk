<?php

namespace Trigold\Udesk;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Trigold\Udesk\Http\Guzzle;

class UdeskServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/udesk.php', 'udesk');

        $this->app->singleton(Crm::class, function ($app) {
            return new Crm(config('udesk'));
        });

        $this->app->alias(Crm::class, 'udesk.crm');

        $this->app->singleton('udesk.http.client', function ($app) {
            return new Guzzle(
                (string) config('udesk.crm.default.url'),
                (int) config('udesk.timeout', 2),
                (array) config('udesk.http.options', [])
            );
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
        return collect(config('udesk.apps', []))
            ->keys()
            ->transform(function ($app, $key) {
                return Str::start($app, 'udesk.');
            })
            ->merge([
                Crm::class,
                'udesk.crm',
                'udesk.http.client',
            ])
            ->all();
    }
}
