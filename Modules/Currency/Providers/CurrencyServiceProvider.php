<?php

namespace Modules\Currency\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\Ui\Facades\TabManager;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Currency\Admin\CurrencyRateTabs;
use Modules\Currency\Console\RefreshCurrencyRatesCommand;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!config('app.installed')) {
            return;
        }

        TabManager::register('currency_rates', CurrencyRateTabs::class);

        if ($this->app->runningInConsole() && setting('auto_refresh_currency_rates', false)) {
            $this->commands(RefreshCurrencyRatesCommand::class);

            $this->registerScheduler();
        }
    }


    private function registerScheduler()
    {
        $this->app->booted(function ($app) {
            $frequency = setting('auto_refresh_currency_rate_frequency');

            if (in_array($frequency, ['daily', 'weekly', 'monthly'])) {
                $app[Schedule::class]->command(RefreshCurrencyRatesCommand::class)->{$frequency}();
            }
        });
    }
}
