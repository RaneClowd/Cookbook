<?php

namespace AppBundle\ViewEntity;

class WeightMeasure extends Measure
{
    public static function getAvailableMeasureUnits() {
        return array("gram"     =>    1.0,
                     "ounce"    =>   28.3495,
                     "pound"    =>  453.592);
    }
    
    public function setAmount($newAmount, $amountUnit = "gram")
    {
        parent::setAmount($newAmount, $amountUnit);
    }
}