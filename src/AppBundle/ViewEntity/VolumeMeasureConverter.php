<?php

namespace AppBundle\ViewEntity;

class VolumeMeasureConverter extends MeasureConverter
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
}