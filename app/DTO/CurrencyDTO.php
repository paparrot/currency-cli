<?php

namespace App\DTO;

class CurrencyDTO
{
    public function __construct(
        public string $name,
        public string $code,
        public float  $value,
    )
    {
    }

    public function toArray()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
