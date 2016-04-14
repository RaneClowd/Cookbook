<?php

namespace AppBundle\ViewEntity;

abstract class Measure
{
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
        return array(VolumeMeasure::class, WeightMeasure::class);
    }
    
    public static function measureTypeForUnit($unit)
    {
        foreach(Measure::allMeasureClasses() as $measureClass) {
            if (array_key_exists($unit, $measureClass::getAvailableMeasureUnits())) {
                return new $measureClass();
            }
        }
        
        throw new \Exception('Unrecognized measurement type: '.$unit);
    }
    
    public function getAmountInLargestUnit()
    {
        foreach($this->getAvailableMeasureUnits() as $unit => $scale) {
            var_dump($unit, $scale, $this->amount);
            if ( !empty($returnUnit) && $this->amount < $returnScale) {
                break;
            } else {
                $returnUnit = $unit;
                $returnScale = $scale;
            }
        }
        
        return array('val' => ($this->amount / $returnScale), 'unit' => $returnUnit);
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    
    public function setAmount($newAmount, $amountUnit)
    {
        $conversionScale = $this->getAvailableMeasureUnits()[$amountUnit];
        if (empty($conversionScale)) {
            throw new \Exception('Unit type not found: '.$amountUnit);
        }
        
        $this->amount = $newAmount * $conversionScale;
    }
}