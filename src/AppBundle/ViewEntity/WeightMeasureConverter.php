<?php

namespace AppBundle\ViewEntity;

class WeightMeasureConverter extends MeasureConverter
{
    public static function getMeasureName()
    {
        return "Weight";
    }
    
    public static function getAvailableMeasureUnits() {
        return array("gram"     =>    1.0,
                     "ounce"    =>   28.3495,
                     "pound"    =>  453.592);
    }
}