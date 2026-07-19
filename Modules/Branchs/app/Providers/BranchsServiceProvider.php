<?php

namespace Modules\Branchs\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class BranchsServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Branchs';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'branchs';


    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];


    public function boot(): void
    {
        $this->loadViewsFrom(
            module_path('Branchs', 'resources/views'),
            'Branchs'
        );

        $this->loadTranslationsFrom(
            module_path('Branchs', 'resources/lang'),
            'Branchs'
        );

        $this->loadMigrationsFrom(
            module_path('Branchs', 'database/migrations')
        );
    }
}