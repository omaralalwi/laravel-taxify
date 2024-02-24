<?php

use Illuminate\Support\Facades\Log;
use Omaralalwi\LaravelTaxify\Enums\TaxConfigKeys;
use Omaralalwi\LaravelTaxify\Enums\TaxDefaults;
use Omaralalwi\LaravelTaxify\Enums\TaxTypes;
use Omaralalwi\LaravelTaxify\Transformers\TaxifyTransformer;
use Omaralalwi\LaravelTaxify\Exceptions\CalculateTaxException;

if (!function_exists('getTaxAmount')) {
    function getTaxAmount(float $amount, ?string $profile = null): float
    {
        try {
            $taxRate = getTaxRate($profile);
            $taxType = getTaxType($profile);

            $calculatedAmount = ($taxType === TaxTypes::PERCENTAGE) ? ($taxRate * $amount) : $taxRate;
            return (float) number_format($calculatedAmount, 2);
        } catch (Throwable $e) {
            $msg = 'Error while getting tax amount: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}

if (!function_exists('getTaxRate')) {
    function getTaxRate(?string $profile = null): float
    {
        $configKeyRate = $profile && !is_null($profile) ?
            "taxify.profiles.$profile." . TaxConfigKeys::RATE :
            "taxify.profiles." . TaxDefaults::PROFILE . '.' . TaxConfigKeys::RATE;

        return (float) config($configKeyRate, TaxDefaults::RATE);
    }
}

if (!function_exists('getTaxRateAsPercentage')) {
    function getTaxRateAsPercentage(?string $profile = null): string
    {
        try {
            $taxRate = getTaxRate($profile);
            $taxType = getTaxType($profile);

            if ($taxType === TaxTypes::PERCENTAGE) {
                return sprintf("%.2f%%", $taxRate * 100);
            } else {
                $msg = 'the getTaxRateAsPercentage only for percentage types of tax profiles ';
                Log::error($msg);
                throw new CalculateTaxException($msg);
            }
        } catch (Throwable $e) {
            $msg = 'Error while getting tax rate as percentage: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}

if (!function_exists('getTaxType')) {
    function getTaxType(?string $profile = null): string
    {
        return $profile && !is_null($profile) ?
            config("taxify.profiles.$profile." . TaxConfigKeys::TYPE) :
            config("taxify.profiles." . TaxDefaults::PROFILE . '.' . TaxConfigKeys::TYPE, TaxTypes::PERCENTAGE);
    }
}

if (!function_exists('calculateTax')) {
    function calculateTax(float $amount, ?string $profile = null, bool $asArray = false): object|array
    {
        try {
            $taxAmount = getTaxAmount($amount, $profile);
                return TaxifyTransformer::transform(($taxAmount + $amount), $taxAmount, getTaxRate($profile), $asArray);
        } catch (Throwable $e) {
            $msg = 'Error while calculating tax for amount: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}

if (!function_exists('calculateTaxForCollection')) {
    function calculateTaxForCollection(array $amounts, ?string $profile = null, bool $asArray = false): object|array
    {
        $totalTax =  0;
        $totalAmountWithTax =  0;

        foreach ($amounts as $amount) {
            $taxDetails = calculateTax($amount, $profile);
            $totalTax += $taxDetails->tax_amount;
            $totalAmountWithTax += $taxDetails->amount_with_tax;
        }

        return TaxifyTransformer::transform($totalAmountWithTax, $totalTax, getTaxRate($profile), $asArray);
    }
}
