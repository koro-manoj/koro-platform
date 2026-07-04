<?php

namespace Modules\Payments\Providers;

use Modules\Payments\Services\PaymentGatewayManager;
use Modules\Payments\Services\StripeGateway;
use Nwidart\Modules\Support\ModuleServiceProvider;

class PaymentsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Payments';

    protected string $nameLower = 'payments';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        $this->app->singleton(PaymentGatewayManager::class, function ($app) {
            $manager = new PaymentGatewayManager;
            $manager->register($app->make(StripeGateway::class));

            return $manager;
        });
    }
}
