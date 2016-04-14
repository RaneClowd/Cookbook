<?php

namespace AppBundle\ViewEntity;

use AppBundle\Entity\Ingredient;

class IngredientPool
{
    private $foodName;
    private $amount;
    private $unit;
    
    public function __construct($amount, $unit, $foodName)
    {
        $this->foodName = $foodName;
        $this->amount = $amount;
        $this->unit = $unit;
    }
    
    public function getFoodName()
    {
        return $this->foodName;
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    
    public function getUnit()
    {
        return $this->unit;
    }
    
    public function addIngredient(Ingredient $ingredient)
    {
        if ($this->foodName !== $ingredient->getFoodItem()->getName()) {
            throw new \Exception("Can't mix ".$ingredient->getFoodItem()->getName()." with ".$this->getFoodName());
        }
        
        if ($this->unit === $ingredient->getUnit()) {
            $this->amount += $ingredient->getAmount();
        } else {
            if (MeasureConverter::compareUnits($this->getUnit(), $ingredient->getUnit()) < 0) {
                // This is smaller, the ingredient needs to convert
                $ingredientMeasure = MeasureConverter::newMeasure($ingredient->getAmount(), $ingredient->getUnit());
                
                $this->amount += $ingredientMeasure->convertTo($this->getUnit());
            } else {
                $newMeasure = MeasureConverter::newMeasure($this->getAmount(), $this->getUnit());
                
                $this->amount = $ingredient->getAmount() + $newMeasure->convertTo($ingredient->getUnit());
                $this->unit = $ingredient->getUnit();
            }
        }
    }
}