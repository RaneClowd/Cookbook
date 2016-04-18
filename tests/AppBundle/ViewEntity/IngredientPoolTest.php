<?php

namespace Tests\AppBundle\ViewEntity;

use AppBundle\ViewEntity\IngredientPool;
use AppBundle\Entity\Ingredient;

class IngredientPoolTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $pool = new IngredientPool(4, 'teaspoon', 'garlic salt');
        $this->assertIngredientPool($pool, 4, 'teaspoon', 'garlic salt');
    }
    
    /**
     * @expectedException           Exception
     * @expectedExceptionMessage    Can't mix rice with mayo
     */
    public function testMismatchException()
    {
        $pool = new IngredientPool(4, 'cup', 'mayo');
        $ingredient = Ingredient::ingredient(2, 'cup', 'rice');
        
        $pool->addIngredient($ingredient);
    }
    
    public function testSimpleAddition()
    {
        $pool = new IngredientPool(2, 'tablespoon', 'ketchup');
        $ingredient = Ingredient::ingredient(3, 'tablespoon', 'ketchup');
        
        $pool->addIngredient($ingredient);
        $this->assertIngredientPool($pool, 5, 'tablespoon', 'ketchup');
    }
    
    public function testConvertedIngredientAddition()
    {
        $pool = new IngredientPool(2, 'teaspoon', 'olive oil');
        $ingredient = Ingredient::ingredient(2, 'tablespoon', 'olive oil');
        
        $pool->addIngredient($ingredient);
        $this->assertIngredientPool($pool, 8, 'teaspoon', 'olive oil');
    }
    
    public function testConvertedPoolAddition()
    {
        $pool = new IngredientPool(1, 'pound', 'ground beef');
        $ingredient = Ingredient::ingredient(8, 'ounce', 'ground beef');
        
        $pool->addIngredient($ingredient);
        $this->assertIngredientPool($pool, 24, 'ounce', 'ground beef');
    }
    
    private function assertIngredientPool($pool, $amount, $unit, $foodname)
    {
        $this->assertEquals($pool->getAmount(), $amount, '', 0.01);
        $this->assertEquals($pool->getUnit(), $unit);
        $this->assertEquals($pool->getFoodName(), $foodname);
    }
}