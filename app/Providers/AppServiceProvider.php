<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Cms\Models\Media;
use Modules\Cms\Models\Page;
use Modules\Cms\Policies\MediaPolicy;
use Modules\Cms\Policies\PagePolicy;
use Modules\Core\Models\Integration;
use Modules\Core\Models\Setting;
use Modules\Core\Policies\IntegrationPolicy;
use Modules\Core\Policies\SettingPolicy;
use Modules\Crm\Models\Contact;
use Modules\Crm\Models\Lead;
use Modules\Crm\Models\Pipeline;
use Modules\Crm\Models\PipelineStage;
use Modules\Crm\Policies\ContactPolicy;
use Modules\Crm\Policies\LeadPolicy;
use Modules\Crm\Policies\PipelinePolicy;
use Modules\Crm\Policies\PipelineStagePolicy;
use Modules\Ecommerce\Models\Product;
use Modules\Ecommerce\Policies\ProductPolicy;
use Modules\Erp\Models\InventoryItem;
use Modules\Erp\Models\Order;
use Modules\Erp\Policies\InventoryItemPolicy;
use Modules\Erp\Policies\OrderPolicy;
use Modules\Payments\Models\Invoice;
use Modules\Payments\Models\Payment;
use Modules\Payments\Models\PaymentWebhook;
use Modules\Payments\Policies\InvoicePolicy;
use Modules\Payments\Policies\PaymentPolicy;
use Modules\Payments\Policies\PaymentWebhookPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(Integration::class, IntegrationPolicy::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);
        Gate::policy(PaymentWebhook::class, PaymentWebhookPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Contact::class, ContactPolicy::class);
        Gate::policy(Lead::class, LeadPolicy::class);
        Gate::policy(Pipeline::class, PipelinePolicy::class);
        Gate::policy(PipelineStage::class, PipelineStagePolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Media::class, MediaPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(InventoryItem::class, InventoryItemPolicy::class);
    }
}
