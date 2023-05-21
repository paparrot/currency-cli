<?php

namespace App\Commands;

use App\Exceptions\CurrenciesNotFoundException;
use App\Services\CurrencyService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Popular extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'show-popular';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Most popular currencies.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CurrencyService $service)
    {
        try {
            $popularRates = $service->loadPopular();
        } catch (CurrenciesNotFoundException $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }

        $this->table([
            'Name',
            'Code',
            'Rate',
        ], $popularRates);

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
