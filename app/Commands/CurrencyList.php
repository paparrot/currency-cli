<?php

namespace App\Commands;

use App\Exceptions\CurrenciesNotFoundException;
use App\Services\CurrencyService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class CurrencyList extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'show-all';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Show currency list.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CurrencyService $service)
    {
        try {
            $currencies = $service->loadCurrencies();
        } catch (CurrenciesNotFoundException $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }


        $this->table([
            'Code',
            'Name',
            'Rate',
        ], $currencies);

        return self::SUCCESS;
    }

    /**
     * Define the command's schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
