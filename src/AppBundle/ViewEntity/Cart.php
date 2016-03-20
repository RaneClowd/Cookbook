<?php

namespace AppBundle\ViewEntity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class Cart
{
    protected $recipe_ids;
    
    public static function currentCart(Request $request) {
        $cart = $request->getSession()->get('planned_meals');
        if (empty($cart)) {
            $cart = new Cart();
            dump($cart);
            $request->getSession()->set('planned_meals', $cart);
        }
        return $cart;
    }
    
    public function __construct()
    {
        $this->recipe_ids = [];
    }
    
    public function addRecipe($recipe_id)
    {
        array_push($this->recipe_ids, $recipe_id);
    }
    
    public function removeRecipe($recipe_id)
    {
        $result = array_search($recipe_id, $this->recipe_ids, true);
        if ($result !== false) {
            unset($this->recipe_ids[$result]);
        }
    }
    
    public function hasRecipe($recipe_id) {
        return in_array($recipe_id, $this->recipe_ids);
    }
    
    public function getRecipeIds()
    {
        return $this->recipe_ids;
    }
}