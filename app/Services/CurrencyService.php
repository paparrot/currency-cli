<?php

namespace App\Services;

use App\Contracts\CurrencyRepository;
use App\DTO\CurrencyDTO;

class CurrencyService
{
    private const popular = ['EUR', 'USD'];

    public function __construct(private CurrencyRepository $source)
    {
        if (!$source) {
            $this->source = CBR::make();
        }
    }

    public function loadCurrencies(): array
    {
        return collect($this->source->get())
            ->map(fn(CurrencyDTO $currency): array => $currency->toArray())
            ->all();
    }

    public function loadPopular(): array
    {
        return collect($this->source->get())
            ->filter(fn(CurrencyDTO $currency): bool => in_array($currency->code, self::popular))
            ->map(fn(CurrencyDTO $currency): array => $currency->toArray())
            ->values()
            ->all();
    }

    public function getCurrency(string $code): ?array
    {
        $currencies = $this->loadCurrencies();

        foreach ($currencies as $currency) {
            if ($currency['code'] === mb_strtoupper($code)) {
                return $currency;
            }
        }

        return null;
    }
}
