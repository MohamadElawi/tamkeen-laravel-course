<?php

namespace App\Traits;

trait TaxCalculatorTrait
{
    public function calculateTax($price){
        $enabledTax = config('taxes.enabled_tax');
        if($enabledTax){
            $taxRate = config('taxes.tax_rate');
            return $price * (1 + $taxRate) ;
        }

        return $price ;
    }
}
