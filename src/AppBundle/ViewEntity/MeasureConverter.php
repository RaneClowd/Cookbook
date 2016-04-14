<?php

namespace AppBundle\ViewEntity;

abstract class MeasureConverter
{
    protected $unit;
    protected $amount;
    
    public static function getMeasureName()
    {
        throw new Exception('needs to be overriden!');
    }
    
    public static function getAvailableMeasureUnits()
    {
        throw new Exception('needs to be overriden!');
    }
    
    public static function allMeasureClasses()
    {
        return array(VolumeMeasureConverter::class, WeightMeasureConverter::class);
    }
    
    public static function newMeasure($amount, $unit)
    {
        foreach(MeasureConverter::allMeasureClasses() as $measureClass) {
            if (array_key_exists($unit, $measureClass::getAvailableMeasureUnits())) {
                return new $measureClass($amount, $unit);
            }
        }
        
        throw new \Exception('Unrecognized measurement type: '.$unit);
    }
    
    public static function compareUnits($unitone, $unittwo)
    {
        foreach(MeasureConverter::allMeasureClasses() as $measureClass) {
            $units = $measureClass::getAvailableMeasureUnits();
            if (array_key_exists($unitone, $units)) {
                $factorOne = $units[$unitone];
                $factorTwo = $units[$unittwo];
                
                return $factorOne <=> $factorTwo;
            }
        }
    }
    
    public function __construct($amount, $unit)
    {
        $this->unit = $unit;
        $this->amount = $amount;
    }
    
    public function convertTo($unit)
    {
        $baseFactor = $this::getAvailableMeasureUnits()[$this->unit];
        $conversionFactor = $this::getAvailableMeasureUnits()[$unit];
        
        return ($this->amount * $baseFactor) / $conversionFactor;
    }
}