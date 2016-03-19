<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\ViewEntity\Cart;

class PlannedController extends Controller
{
    /**
     * @Route("/planned", name="planned_recipes")
     */
    public function plannedListAction(Request $request)
    {
        $recipe_ids = Cart::currentCart($request)->getRecipeIds();
        $recipeRepository = $this->getDoctrine()->getRepository('AppBundle:Recipe');
        $plannedRecipes = $recipeRepository->findByIdsJoinedToFooditems($recipe_ids);
        
        return $this->render('plannedRecipes.html.twig', array('plannedRecipes' => $plannedRecipes,
                                                               'groceries' => $this->groceryListForRecipes($plannedRecipes)));
    }
    
    /**
     * @Route("/addrecipe/{id}", name="add_to_planned")
     */
    public function addAction(Request $request, $id) {
        Cart::currentCart($request)->addRecipe($id);
        return new Response();
    }
    
    /**
     * @Route("/removerecipe/{id}", name="remove_from_planned")
     */
    public function removeAction(Request $request, $id) {
        Cart::currentCart($request)->removeRecipe($id);
        return new Response();
    }
    
    protected function groceryListForRecipes($recipes) {
        $list = [];
        foreach ($recipes as $recipe) {
            foreach ($recipe->getIngredients() as $ingredient) {
                $foodItem = $ingredient->getFooditem();
                
                if ( !array_key_exists($foodItem->getName(), $list)) {
                    $list[$foodItem->getName()] = $ingredient->getAmount();
                } else {
                    // TODO: set up structure for adding amounts based on units
                }
            }
        }
        
        return $list;
    }
}
