<?php

namespace App\Contracts;

interface CurrencyRepository
{
    public function get(): array;
}
