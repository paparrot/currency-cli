<?php

namespace App\Services;

use App\Contracts\CurrencyRepository;
use App\DTO\CurrencyDTO;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Exceptions\CurrenciesNotFoundException;
use Illuminate\Support\Str;
use Spatie\LaravelData\DataCollection;
use Throwable;

class CBR implements CurrencyRepository
{
    private const ENDPOINT = 'https://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * @throws Throwable
     */
    public function get(): array
    {
        $response = Http::get(self::ENDPOINT);

        throw_if(!$response->status() === Response::HTTP_OK, CurrenciesNotFoundException::class);

        throw_if(!$response->body(), CurrenciesNotFoundException::class);

        try {
            $currencyData = $this->xmlToArray(simplexml_load_string($response->body()));
        } catch (Exception) {
            throw new CurrenciesNotFoundException();
        }


        throw_if(!array_key_exists('Valute', $currencyData), CurrenciesNotFoundException::class);

        $responseCurrencies = $currencyData['Valute'];

        $result = [];

        foreach ($responseCurrencies as $responseCurrency) {
            $value = (float)Str::replace(',', '.', $responseCurrency['Value']);
            $nominal = (float)$responseCurrency['Nominal'];
            if ($nominal > 1) {
                $value = $value / $nominal;
            }

            $result[] = new CurrencyDTO(
                name: $responseCurrency['Name'],
                code: $responseCurrency['CharCode'],
                value: $value
            );
        }

        return array_values($result);
    }

    private function xmlToArray($xml): array
    {
        return json_decode(json_encode($xml), 1);
    }
}
