<?php

namespace Omaralalwi\LaravelTaxify\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaxifyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the getTaxAmount function.
     *
     * @return void
     */
    public function testGetTaxAmount()
    {
        $amount = 100;
        $profile = 'default';

        $taxAmount = getTaxAmount($amount, $profile);

        // Assert that the result is a float
        $this->assertIsFloat($taxAmount);

        // Assert that the tax amount is calculated correctly
        $this->assertEquals(10, $taxAmount); // Adjust this based on your tax calculation logic
    }

    /**
     * Test the getTaxRate function.
     *
     * @return void
     */
    public function testGetTaxRate()
    {
        $profile = 'default';

        $taxRate = getTaxRate($profile);

        // Assert that the result is a float
        $this->assertIsFloat($taxRate);

        // Assert that the tax rate is retrieved correctly from the configuration
        $this->assertEquals(0.10, $taxRate); // Adjust this based on your default tax rate
    }

    /**
     * Test the getTaxRateAsPercentage function.
     *
     * @return void
     */
    public function testGetTaxRateAsPercentage()
    {
        $profile = 'default';

        $taxRatePercentage = getTaxRateAsPercentage($profile);

        // Assert that the result is a string
        $this->assertIsString($taxRatePercentage);

        // Assert that the tax rate is formatted as a percentage correctly
        $this->assertEquals('10.00%', $taxRatePercentage); // Adjust this based on your formatting logic
    }

    /**
     * Test the getTaxType function.
     *
     * @return void
     */
    public function testGetTaxType()
    {
        $profile = 'default';

        $taxType = getTaxType($profile);

        // Assert that the result is a string
        $this->assertIsString($taxType);

        // Assert that the tax type is retrieved correctly from the configuration
        $this->assertEquals('percentage', $taxType); // Adjust this based on your default tax type
    }

    /**
     * Test the calculateTax function.
     *
     * @return void
     */
    public function testCalculateTax()
    {
        $amount = 100;
        $profile = 'default';

        $taxDetails = calculateTax($amount, $profile);

        // Assert that the result is an object
        $this->assertIsObject($taxDetails);

        // Assert that the tax details are calculated correctly
        $this->assertEquals(110, $taxDetails->amount_with_tax); // Adjust this based on your tax calculation logic
        $this->assertEquals(10, $taxDetails->tax_amount); // Adjust this based on your tax calculation logic
        $this->assertEquals(0.10, $taxDetails->tax_rate); // Adjust this based on your default tax rate
    }

    /**
     * Test the calculateTaxForCollection function.
     *
     * @return void
     */
    public function testCalculateTaxForCollection()
    {
        $amounts = [100, 50, 75];
        $profile = 'default';

        $totalTaxDetails = calculateTaxForCollection($amounts, $profile);

        // Assert that the result is an object
        $this->assertIsObject($totalTaxDetails);

        // Assert that the total tax details are calculated correctly
        $this->assertEquals(337.5, $totalTaxDetails->amount_with_tax); // Adjust this based on your tax calculation logic
        $this->assertEquals(37.5, $totalTaxDetails->tax_amount); // Adjust this based on your tax calculation logic
        $this->assertEquals(0.10, $totalTaxDetails->tax_rate); // Adjust this based on your default tax rate
    }
}
