<?php

namespace Tests\Feature;

use Omaralalwi\LaravelTaxify\Enums\{TaxConfigKeys, TaxDefaults, TaxifyKeys, TaxTypes};
use Tests\TestCase;

class TaxifyTest extends TestCase
{
    public function testGetTaxRate()
    {
        $profile = TaxDefaults::PROFILE;
        $configKeyRate = $profile && !is_null($profile) ?
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::RATE :
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::RATE;
        $expectedTaxRate = (float) config($configKeyRate, TaxDefaults::RATE);
        $taxRate = getTaxRate($profile);

        $this->assertIsFloat($taxRate);
        $this->assertEquals($expectedTaxRate, $taxRate);
    }

    public function testGetTaxType()
    {
        $profile = TaxDefaults::PROFILE;

        $configKeyType = $profile && !is_null($profile) ?
            config(TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::TYPE) :
            config(TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::TYPE, TaxTypes::PERCENTAGE);
        $expectedTaxType = config($configKeyType, TaxDefaults::TYPE);
        $taxType = getTaxType($profile);

        $this->assertIsString($taxType);
        $this->assertEquals($expectedTaxType, $taxType);
    }

    public function testGetTaxAmount()
    {
        $amount = TaxDefaults::TEST_AMOUNT;
        $profile = TaxDefaults::PROFILE;
        $taxRate = getTaxRate($profile);
        $taxType = getTaxType($profile);
        $expectedTaxAmount = ($taxType === TaxTypes::PERCENTAGE) ? ($taxRate * $amount) : $taxRate;
        $taxAmount = getTaxAmount($amount, $profile);

        $this->assertIsFloat($taxAmount);
        $this->assertEquals($expectedTaxAmount, $taxAmount);
    }

    public function testCalculateTaxThenReturnObject()
    {
        $amount = TaxDefaults::TEST_AMOUNT;
        $profile = TaxDefaults::PROFILE;
        $taxType = getTaxType($profile);

        $configKeyRate = $profile && !is_null($profile) ?
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::RATE :
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::RATE;

        $expectedTaxRate = (float) config($configKeyRate, TaxDefaults::RATE);

        $expectedTaxAmount = ($taxType === TaxTypes::PERCENTAGE) ? ($expectedTaxRate * $amount) : $expectedTaxRate;
        $expectedAmountWithTax = ($expectedTaxAmount + $amount);

        $taxDetails = calculateTax($amount, $profile);
        $this->assertIsObject($taxDetails);

        $this->assertEquals($expectedAmountWithTax, $taxDetails->amount_with_tax);
        $this->assertEquals($expectedTaxAmount, $taxDetails->tax_amount);
        $this->assertEquals($expectedTaxRate, $taxDetails->tax_rate);
    }

    public function testCalculateTaxThenReturnArray()
    {
        $amount = TaxDefaults::TEST_AMOUNT;
        $profile = TaxDefaults::PROFILE;
        $taxType = getTaxType($profile);

        $configKeyRate = $profile && !is_null($profile) ?
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::RATE :
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::RATE;

        $expectedTaxRate = (float) config($configKeyRate, TaxDefaults::RATE);

        $expectedTaxAmount = ($taxType === TaxTypes::PERCENTAGE) ? ($expectedTaxRate * $amount) : $expectedTaxRate;
        $expectedAmountWithTax = ($expectedTaxAmount + $amount);

        $taxDetails = calculateTax($amount, $profile, true);
        $this->assertIsArray($taxDetails);

        $this->assertEquals($expectedAmountWithTax, $taxDetails['amount_with_tax']);
        $this->assertEquals($expectedTaxAmount, $taxDetails['tax_amount']);
        $this->assertEquals($expectedTaxRate, $taxDetails['tax_rate']);
    }

    public function testCalculateTaxForCollection()
    {
        $amount = TaxDefaults::TEST_AMOUNT;
        $amounts = [$amount*2, $amount*3, $amount*4];
        $profile = TaxDefaults::PROFILE;
        $configKeyRate = $profile && !is_null($profile) ?
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.$profile.'.'.TaxConfigKeys::RATE :
            TaxifyKeys::CONFIG_FILE.'.'.TaxifyKeys::PROFILES_CONFIG_KEY.'.'.TaxDefaults::PROFILE.'.'.TaxConfigKeys::RATE;

        $expectedTaxRate = (float) config($configKeyRate, TaxDefaults::RATE);
        $expectedTotalTax =  0;
        $expectedTotalAmountWithTax =  0;

        foreach ($amounts as $amountItem) {
            $taxDetails = calculateTax($amountItem, $profile);
            $expectedTotalTax += $taxDetails->tax_amount;
            $expectedTotalAmountWithTax += $taxDetails->amount_with_tax;
        }

        $totalTaxDetails = calculateTaxForCollection($amounts, $profile);
        $this->assertIsObject($totalTaxDetails);

        $this->assertEquals($expectedTotalAmountWithTax, $totalTaxDetails->amount_with_tax);
        $this->assertEquals($expectedTotalTax, $totalTaxDetails->tax_amount);
        $this->assertEquals($expectedTaxRate, $totalTaxDetails->tax_rate);
    }

}
