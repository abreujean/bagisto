<?php

namespace Webkul\Asaas\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Webkul\Asaas\Listeners\Transaction;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'sales.invoice.save.after' => [
            Transaction::class,
        ],
    ];
}
