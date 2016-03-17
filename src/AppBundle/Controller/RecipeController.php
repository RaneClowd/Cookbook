<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\FoodItem;

class RecipeController extends Controller
{
    /**
     * @Route("/new", name="new_recipe")
     */
    public function newRecipeAction()
    {
        return $this->render('newrecipe.html.twig');
    }
    
    /**
     * @Route("/saveRecipe", name="save_recipe")
     */
    public function saveRecipeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $content = $request->getContent();
        if ( !empty($content)) {
            $data = json_decode($content);
            
            $recipe = new Recipe();
            $recipe->setName($data->name);
            $em->persist($recipe);
            
            foreach($data->ingredients as $dataItem) {
                $foodItem = new FoodItem();
                $foodItem->setName($dataItem->name);
                $em->persist($foodItem);
                
                $ingredient = new Ingredient();
                $ingredient->setMeasure($dataItem->unit);
                $ingredient->setAmount($dataItem->amount);
                $ingredient->setFooditem($foodItem);
                $em->persist($ingredient);
                
                $recipe->addIngredient($ingredient);
            }
        }
        
        $em->flush();
        return new Response(json_encode(array('hello' => 'bob')));
    }
}
