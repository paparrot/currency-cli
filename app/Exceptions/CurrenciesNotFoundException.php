<?php

namespace App\Exceptions;

use Exception;

class CurrenciesNotFoundException extends Exception
{
    public $message = 'Currencies not found.';

    public $code = 404;
}
