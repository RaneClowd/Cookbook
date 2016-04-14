<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Ingredient;

class IngredientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $ingredient = Ingredient::withAmount(4, 'teaspoon');
        $this->assertIngredientVals($ingredient, 4, 'teaspoon');
    }
    
    public function testSimpleAddition()
    {
        $ingrA = Ingredient::withAmount(2, 'tablespoon');
        $ingrB = Ingredient::withAmount(3, 'tablespoon');
        
        $ingrC = $ingrA->newInstanceByAdding($ingrB);
        
        $this->assertIngredientVals($ingrC, 5, 'tablespoon');
    }
    
    private function assertIngredientVals($ingredient, $amount, $unit)
    {
        $this->assertEquals($ingredient->getAmount(), $amount);
        $this->assertEquals($ingredient->getUnit(), $unit);
    }
}