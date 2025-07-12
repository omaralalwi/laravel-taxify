<?php

use Illuminate\Support\Facades\Log;
use Omaralalwi\LaravelTaxify\Transformers\TaxifyTransformer;
use Omaralalwi\LaravelTaxify\Exceptions\CalculateTaxException;
use Omaralalwi\LaravelTaxify\Enums\{TaxifyKeys, TaxConfigKeys, TaxDefaults, TaxTypes};

/**
 * Calculate the tax amount based on the given amount and tax profile.
 *
 * @param float $amount The original amount to calculate tax for.
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 *
 * @return float The calculated tax amount.
 *
 * @throws CalculateTaxException If an error occurs during the calculation.
 */
if (!function_exists('getTaxAmount')) {
    function getTaxAmount(float $amount, ?string $profile = null): float
    {
        try {
            $taxRate = getTaxRate($profile);
            $taxType = getTaxType($profile);

            $calculatedAmount = ($taxType === TaxTypes::PERCENTAGE) ? ($taxRate * $amount) : $taxRate;
            return round($calculatedAmount,2);
        } catch (Throwable $e) {
            $msg = 'Error while getting tax amount: ' . $e->getMessage();
            Log::error($msg);
            throw new CalculateTaxException($msg);
        }
    }
}

/**
 * Get the tax rate based on the given tax profile.
 *
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 *
 * @return float The tax rate.
 */
if (!function_exists('getTaxRate')) {
    function getTaxRate(?string $profile = null): float
    {
        $configKeyRate = $profile && !is_null($profile) ?
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::RATE :
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::RATE;

        return round(config($configKeyRate, TaxDefaults::RATE), 2);
    }
}

/**
 * Get the tax rate formatted as a percentage based on the given tax profile.
 *
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 *
 * @return string The formatted tax rate as a percentage.
 *
 * @throws CalculateTaxException If an error occurs during the calculation.
 */
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

/**
 * Get the tax type based on the given tax profile.
 *
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 *
 * @return string The tax type.
 */
if (!function_exists('getTaxType')) {
    function getTaxType(?string $profile = null): string
    {
        return $profile && !is_null($profile) ?
            config(TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::TYPE) :
            config(TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::TYPE, TaxTypes::PERCENTAGE);
    }
}

/**
 * Calculate the tax details based on the given amount, tax profile, and format preference.
 *
 * @param float $amount The original amount to calculate tax for.
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 * @param bool $asArray Whether to return the result as an array.
 *
 * @return object|array The tax details object or array.
 *
 * @throws CalculateTaxException If an error occurs during the calculation.
 */
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

/**
 * Calculate the total tax details for a collection of amounts based on the given tax profile and format preference.
 *
 * @param array $amounts The collection of amounts to calculate tax for.
 * @param string|null $profile The tax profile to use. If not provided, the default profile will be used.
 * @param bool $asArray Whether to return the result as an array.
 *
 * @return object|array The total tax details object or array.
 *
 * @throws CalculateTaxException If an error occurs during the calculation.
 */
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
