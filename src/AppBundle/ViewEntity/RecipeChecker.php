<?php

namespace AppBundle\ViewEntity;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Step;

class RecipeChecker
{
    
    protected $recipe;
    
    protected $ingredientsNeeded;
    protected $ingredientsToRemove;
    protected $stepsNeeded;
    protected $stepsToRemove;
    protected $ingredientsToUpdate;
    protected $stepsToUpdate;
    
    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
        $this->ingredientsNeeded = [];
        $this->ingredientsToRemove = [];
        $this->stepsNeeded = [];
        $this->stepsToRemove = [];
    }
    
    public function getIngredientsNeeded()
    {
        return $this->ingredientsNeeded;
    }
    
    public function getIngredientsToRemove()
    {
        return $this->ingredientsToRemove;
    }
    
    public function getStepsNeeded()
    {
        return $this->stepsNeeded;
    }
    
    public function getStepsToRemove()
    {
        return $this->stepsToRemove;
    }
    
    public function checkForIngredients($ingredientsList)
    {
        foreach ($this->recipe->getIngredients() as $ingredient) {
            $ingredient_found = false;
            foreach ($ingredientsList as $itemIndex => $listItem) {
                if ($ingredient->getFoodItem()->getName() == $listItem->name) {
                    unset($ingredientsList[$itemIndex]);
                    
                    $this->updateIngredient($ingredient, $listItem);
                    
                    $ingredient_found = true;
                    break;
                }
            }
            
            if (!$ingredient_found) {
                $this->ingredientNeedsRemoval($ingredient);
            }
        }
        
        foreach ($ingredientsList as $listItem) {
            if (isset($listItem->unit)) {
                $ingredient = Ingredient::ingredient($listItem->amount, $listItem->unit, $listItem->name);
            } else {
                $ingredient = Ingredient::ingredient($listItem->amount, null, $listItem->name);
            }
            $ingredient->setNote($listItem->note);
            
            array_push($this->ingredientsNeeded, $ingredient);
        }
    }
    
    public function checkForSteps($stepList)
    {
        for ($index = 0; $index < count($stepList); $index += 1) {
            if ($index < count($this->recipe->getSteps())) {
                $recipe_step = $this->recipe->getSteps()[$index];
                $recipe_step->setDescription($stepList[$index]);
            } else {
                $step = Step::step($index + 1, $stepList[$index]);
                
                array_push($this->stepsNeeded, $step);
            }
        }
        
        for ($index = count($stepList); $index < count($this->recipe->getSteps()); $index += 1) {
            $this->stepNeedsRemoval($this->recipe->getSteps()[$index]);
        }
    }
    
    private function updateIngredient($ingredient, $listItem)
    {
        $ingredient->setAmount($listItem->amount);
        if (isset($listItem->unit)) $ingredient->setUnit($listItem->unit);
        else $ingredient->setUnit(null);
        $ingredient->setNote($listItem->note);
    }
    
    private function ingredientNeedsRemoval(Ingredient $ingredient)
    {
        array_push($this->ingredientsToRemove, $ingredient);
    }
    
    private function stepNeedsRemoval(Step $step)
    {
        array_push($this->stepsToRemove, $step);
    }
}