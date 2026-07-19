<?php

namespace Modules\User\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;

class UserServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'User';

    protected string $nameLower = 'user';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];


    public function boot(): void
    {
        $this->loadViewsFrom(
            module_path('User', 'resources/views')
            'User'
        );
    }
}