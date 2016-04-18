<?php

namespace AppBundle\ViewEntity;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Ingredient;

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
            foreach ($ingredientsList as $listItem) {
                if ($ingredient->getFoodItem()->getName() == $listItem->name) {
                    $index = array_search($listItem, $ingredientsList);
                    unset($ingredientsList[$index]);
                    
                    break;
                }
            }
            
            // No matching ingredient found
            $this->ingredientNeedsRemoval($ingredient);
        }
        
        foreach ($ingredientsList as $listItem) {
            $ingredient = Ingredient::ingredient($listItem->amount, $listItem->unit, $listItem->name);
            $ingredient->setNote($listItem->note);
            
            array_push($this->ingredientsNeeded, $ingredient);
        }
    }
    
    public function checkForSteps($steps)
    {
        
    }
    
    public function ingredientNeedsRemoval(Ingredient $ingredient)
    {
        array_push($this->ingredientsToRemove, $ingredient);
    }
}