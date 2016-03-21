<?php

namespace AppBundle\ViewEntity;

abstract class Measure
{
    protected $amount;
    
    public static function getAvailableMeasureUnits() {
        return new Exception('needs to be overriden!');
    }
    
    public static function getMeasureType($type) {
        if ($type == 'volume') {
            return new VolumeMeasure();
        } else if ($type == 'weight') {
            return new WeightMeasure();
        } else {
            throw new Exception('Unrecognized measurement type: '.$type);
        }
    }
    
    public function getAmountInLargestUnit()
    {
        foreach($this->getAvailableMeasureUnits() as $unit => $scale) {
            var_dump($unit, $scale, $this->amount);
            if ( !empty($returnUnit) && $this->amount < $returnScale) {
                break;
            } else {
                echo 'setting stuff';
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
            throw new Exception('Unit type not found: '.$amountUnit);
        }
        
        $this->amount = $newAmount * $conversionScale;
    }
}