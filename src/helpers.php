<?php

use Illuminate\Support\Facades\Log;
use Omaralalwi\LaravelTaxify\Enums\TaxConfigKeys;
use Omaralalwi\LaravelTaxify\Enums\TaxTransformKeys;
use Omaralalwi\LaravelTaxify\Enums\TaxDefaults;
use Omaralalwi\LaravelTaxify\Transformers\TaxifyTransformer;
use Omaralalwi\LaravelTaxify\Exceptions\CalculateTaxException;


if (!function_exists('getTaxAmount')) {
    function getTaxAmount($amount, $profile = null): float
    {
        try {
            $taxRate = getTaxRate($profile);

            if (is_numeric($amount)) {
                return ($taxRate * $amount);
            } else {
                Log::error("Error while calculating tax. Provided number is not numeric. Provided value is: $amount");
            }
        } catch (Throwable $e) {
            $msg = 'Error while getting tax amount: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}

if (!function_exists('getTaxRate')) {
    function getTaxRate($profile = null): float
    {
        return $profile  && !is_null($profile) ?
            config("taxify.profiles.$profile." . TaxConfigKeys::RATE, 0.0) :
            config("taxify.profiles." . TaxDefaults::PROFILE . '.' . TaxConfigKeys::RATE, 0.0);
    }
}

// return result as object by default
if (!function_exists('calculateTax')) {
    function calculateTax($amount, $profile = null, $asArray = false)
    {
        try {
            $taxAmount = getTaxAmount($amount, $profile);
            $taxRate = getTaxRate($profile);

            if ($asArray) {
                return TaxifyTransformer::transformToArray(($taxAmount + $amount), $taxAmount, $taxRate);
            } else {
                return TaxifyTransformer::transformToObject(($taxAmount + $amount), $taxAmount, $taxRate);
            }
        } catch (Throwable $e) {
            $msg = 'Error while calculating tax for amount: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}
