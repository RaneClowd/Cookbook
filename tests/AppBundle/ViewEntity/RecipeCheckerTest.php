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
        $this->assertIngredientNotInArray($checker->getIngredientsNeeded(), 4, 'teaspoon', 'salt', '');
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
        $this->assertIngredientNotInArray($checker->getIngredientsToRemove(), 4, 'teaspoon', 'salt', '');
    }
    
    public function testUpdateIngredient()
    {
        $recipe = new Recipe();
        $recipe->addIngredient(Ingredient::ingredient(4, 'teaspoon', 'salt'));
        $checker = new RecipeChecker($recipe);
        
        $ingredient_list = [];
        array_push($ingredient_list, (object)array('amount'=>3, 'unit'=>'tablespoon', 'name'=>'salt', 'note'=>'updated'));
        $checker->checkForIngredients($ingredient_list);
        
        $this->assertIngredientNotInArray($recipe->getIngredients(), 4, 'teaspoon', 'salt', '');
        $this->assertIngredientInArray($recipe->getIngredients(), 3, 'tablespoon', 'salt', 'updated');
    }
    
    public function testAddStep()
    {
        $recipe = new Recipe();
        $recipe->addStep(Step::step(1, 'cook food'));
        $checker = new RecipeChecker($recipe);
        
        $stepList = [];
        array_push($stepList, 'cook food');
        array_push($stepList, 'eat food');
        $checker->checkForSteps($stepList);
        
        $this->assertStepInArray($checker->getStepsNeeded(), 2, 'eat food');
        $this->assertStepNotInArray($checker->getStepsNeeded(), 1, 'cook food');
    }
    
    public function testRemoveStep()
    {
        $recipe = new Recipe();
        $recipe->addStep(Step::step(1, 'cook food'));
        $recipe->addStep(Step::step(2, 'burn food'));
        $checker = new RecipeChecker($recipe);
        
        $step_list = [];
        array_push($step_list, 'cook food');
        $checker->checkForSteps($step_list);
        
        $this->assertStepInArray($checker->getStepsToRemove(), 2, 'burn food');
        $this->assertStepNotInArray($checker->getStepsToRemove(), 1, 'cook food');
    }
    
    public function testUpdateStep()
    {
        $recipe = new Recipe();
        $recipe->addStep(Step::step(1, 'cook food'));
        $recipe->addStep(Step::step(2, 'throw food away'));
        $checker = new RecipeChecker($recipe);
        
        $step_list = [];
        array_push($step_list, 'cook food');
        array_push($step_list, 'eat food');
        $checker->checkForSteps($step_list);
        
        $this->assertStepInArray($recipe->getSteps(), 1, 'cook food');
        $this->assertStepInArray($recipe->getSteps(), 2, 'eat food');
    }
    
    private function assertIngredientInArray($array, $amount, $unit, $food, $note)
    {
        $ingredient = $this->ingredientFromArray($array, $amount, $unit, $food, $note);
        $this->assertNotNull($ingredient, 'ingredient "'.$amount.' '.$unit.' '.$food.' ('.$note.')" not found');
    }
    
    private function assertIngredientNotInArray($array, $amount, $unit, $food, $note)
    {
        $ingredient = $this->ingredientFromArray($array, $amount, $unit, $food, $note);
        $this->assertNull($ingredient, 'ingredient "'.$amount.' '.$unit.' '.$food.'" should not be listed');
    }
    
    private function assertStepInArray($array, $position, $desc)
    {
        $step = $this->stepFromArray($array, $position, $desc);
        $this->assertNotNull($step, 'step "'.$desc.'" not found');
    }
    
    private function assertStepNotInArray($array, $position, $desc)
    {
        $step = $this->stepFromArray($array, $position, $desc);
        $this->assertNull($step, 'step "'.$desc.'" should not be listed');
    }
    
    private function ingredientFromArray($array, $amount, $unit, $food, $note)
    {
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
    
    private function stepFromArray($array, $position, $desc) {
        foreach ($array as $step) {
            if ($step->getPosition() == $position &&
                    $step->getDescription() == $desc) {
                return $step;
            }
        }
        
        return null;
    }
}