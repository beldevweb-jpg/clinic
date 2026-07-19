<?php

namespace Modules\EKYC\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Support\Facades\Route;

use Modules\EKYC\Contracts\SmartCardReaderInterface;
use Modules\EKYC\Drivers\MockSmartCardReader;
use Modules\EKYC\Readers\ThaiSmartCardReader;

class EKYCServiceProvider extends ModuleServiceProvider
{

    protected string $name = 'EKYC';

    protected string $nameLower = 'ekyc';



    public function register(): void
    {
        $this->app->bind(
            SmartCardReaderInterface::class,
            function () {

                return match (env('SMARTCARD_DRIVER')) {

                    'thai' => new ThaiSmartCardReader(),

                    default => new MockSmartCardReader(),
                };
            }
        );
    }



    public function boot(): void
    {
        $this->registerRoutes();
    }



    protected function registerRoutes(): void
    {
        Route::middleware('web')
            ->group(module_path('EKYC', 'routes/web.php'));
    }



    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];
}
