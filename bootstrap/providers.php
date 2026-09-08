<?php

use App\Modules\Admin\AdminServiceProvider;
use App\Modules\Catalog\CatalogServiceProvider;
use App\Modules\Kitchen\KitchenServiceProvider;
use App\Modules\Ordering\OrderingServiceProvider;
use App\Modules\Payments\PaymentsServiceProvider;
use App\Modules\Reporting\ReportingServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\VoltServiceProvider;

return [
    AdminServiceProvider::class,
    CatalogServiceProvider::class,
    KitchenServiceProvider::class,
    OrderingServiceProvider::class,
    PaymentsServiceProvider::class,
    ReportingServiceProvider::class,
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    VoltServiceProvider::class,
];
