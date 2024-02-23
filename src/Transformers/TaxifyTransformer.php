<?php

namespace Omaralalwi\LaravelTaxify\Transformers;

use Omaralalwi\LaravelTaxify\Enums\TaxTransformKeys;

class TaxifyTransformer
{
    public static function transformToObject($totalAmount, $taxAmount, $taxRate = null): object
    {
        $values = self::transformValues($totalAmount, $taxAmount, $taxRate);

        return (object)$values;
    }

    public static function transformToArray($totalAmount, $taxAmount, $taxRate = null): array
    {
        return self::transformValues($totalAmount, $taxAmount, $taxRate);
    }


    private static function transformValues($totalAmount, $taxAmount, $taxRate = null): array
    {
        $taxRate = $taxRate ?: getTaxRate();

        return [
            TaxTransformKeys::AMOUNT_WITH_TAX => $totalAmount,
            TaxTransformKeys::TAX_AMOUNT => $taxAmount,
            TaxTransformKeys::TAX_RATE => $taxRate,
        ];
    }
}
