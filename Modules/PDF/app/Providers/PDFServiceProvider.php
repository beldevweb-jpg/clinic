<?php

namespace Modules\PDF\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class PDFServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'PDF';

    protected string $nameLower = 'pdf';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();

        $this->loadViewsFrom(
            module_path($this->name, 'resources/views'),
            $this->nameLower
        );
    }
}
