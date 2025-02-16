<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Auto\AutoRepository;
use App\Repositories\Auto\AutoRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    protected array $repositories = [
        AutoRepositoryContract::class => AutoRepository::class,
    ];

    public function register(): void
    {
        \Illuminate\Support\Carbon::setLocale(config('app.locale'));

        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    public function boot(UrlGenerator $url): void
    {
        if (!$this->app->isLocal() && !$this->app->runningUnitTests()) {
            $url->forceScheme('https');
        }

        Model::unguard();
    }
}
