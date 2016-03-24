<?php

namespace AppBundle\ViewEntity;

class VolumeMeasure extends Measure
{
    public static function getMeasureName()
    {
        return "Volume";
    }
    
    public static function getAvailableMeasureUnits() {
        return array("ml"           =>   1.0,
                     "teaspoon"     =>   4.9289,
                     "tablespoon"   =>  14.7868,
                     "cup"          => 236.588);
    }
    
    public function setAmount($newAmount, $amountUnit = "ml")
    {
        parent::setAmount($newAmount, $amountUnit);
    }
}