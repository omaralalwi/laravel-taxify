<?php

namespace Omaralalwi\LaravelTaxify\Transformers;

use Omaralalwi\LaravelTaxify\Enums\TaxTransformKeys;

class TaxifyTransformer
{
    public static function transform($totalAmount, $taxAmount, $taxRate = null, $asArray = false): object|array
    {
        $values = self::transformValues($totalAmount, $taxAmount, $taxRate);
        return $asArray ? $values : (object)$values;
    }

    private static function transformValues(float $totalAmount, float $taxAmount, ?float $taxRate = null): array
    {
        $taxRate = $taxRate ?: getTaxRate();

        return [
            TaxTransformKeys::AMOUNT_WITH_TAX => (float) number_format($totalAmount, 2),
            TaxTransformKeys::TAX_AMOUNT => (float) number_format($taxAmount, 2),
            TaxTransformKeys::TAX_RATE => (float) number_format($taxRate, 2),
        ];
    }

}
