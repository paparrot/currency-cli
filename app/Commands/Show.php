<?php

namespace App\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Show extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'show
        {code : The code of currency you want to see (required)}
    ';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Show currency rates by code.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CurrencyService $service)
    {
        $code = mb_strtoupper($this->argument('code'));

        if (!$code) {
            $this->error("Currency code is required.");
        }

        $currency = $service->getCurrency($code);

        if (!$currency) {
            $this->error("Currency not found.");
            return self::FAILURE;
        }

        $this->info("{$currency['name']} ({$code}): {$currency['value']}");
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
