<?php

namespace Omaralalwi\LaravelTaxify\Exceptions;

use Exception;
use Throwable;

class CalculateTaxException extends Exception
{
    public function __construct($message = "Tax Calculation Error: ", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
