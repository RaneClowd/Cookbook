<?php

namespace Tests\AppBundle\ViewEntity;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Step;

use AppBundle\ViewEntity\RecipeChecker;

class RecipeEditorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddIngredient()
    {
        $recipe = new Recipe();
        $recipe->addIngredient(Ingredient::ingredient(4, 'teaspoon', 'salt'));
        $checker = new RecipeChecker($recipe);
        
        $ingredientList = [];
        array_push($ingredientList, (object)array('amount'=>4, 'unit'=>'teaspoon', 'name'=>'salt', 'note'=>''));
        array_push($ingredientList, (object)array('amount'=>3, 'unit'=>'cup', 'name'=>'water', 'note'=>''));
        $checker->checkForIngredients($ingredientList);
        
        $this->assertIngredientInArray($checker->getIngredientsNeeded(), 3, 'cup', 'water', '');
    }
    
    public function testRemoveIngredient()
    {
        $recipe = new Recipe();
        $recipe->addIngredient(Ingredient::ingredient(4, 'teaspoon', 'salt'));
        $recipe->addIngredient(Ingredient::ingredient(3, 'cup', 'water'));
        $checker = new RecipeChecker($recipe);
        
        $ingredientList = [];
        array_push($ingredientList, (object)array('amount'=>4, 'unit'=>'teaspoon', 'name'=>'salt', 'note'=>''));
        $checker->checkForIngredients($ingredientList);
        
        $this->assertIngredientInArray($checker->getIngredientsToRemove(), 3, 'cup', 'water', '');
    }
    
    public function testAddStep()
    {
        $recipe = new Recipe();
        $recipe->addStep(Step::step(1, 'cook food'));
        $checker = new RecipeChecker($recipe);
        
        $stepList = [];
        array_push($stepList, 'eat food');
        $checker->checkForSteps($stepList);
        
        $this->assertTrue(in_array('eat food', $checker->getStepsNeeded()));
    }
    
    private function assertIngredientInArray($array, $amount, $unit, $food, $note)
    {
        $ingredient = $this->ingredientFromArray($array, $amount, $unit, $food, $note);
        $this->assertNotNull($ingredient);
    }
    
    private function assertIngredientNotInArray($array, $amount, $unit, $food, $note)
    {
        $ingredient = $this->ingredientFromArray($array, $amount, $unit, $food, $note);
        $this->assertNull($ingredient);
    }
    
    private function ingredientFromArray($array, $amount, $unit, $food, $note)
    {
        $ingredientFound = false;
        foreach ($array as $ingredient) {
            if ($ingredient->getFooditem()->getName() == $food &&
                $ingredient->getAmount() == $amount &&
                $ingredient->getUnit() == $unit &&
                $ingredient->getNote() == $note) {
                return $ingredient;
            }
        }
        
        return null;
    }
}