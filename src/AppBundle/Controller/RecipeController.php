<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Step;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\FoodItem;
use AppBundle\ViewEntity\Cart;

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
     * @Route("/all", name="recipe_list")
     */
    public function listRecipesAction()
    {
        $recipeRepository = $this->getDoctrine()->getRepository('AppBundle:Recipe');
        $recipes = $recipeRepository->findAll();
        return $this->render('recipes/recipelist.html.twig', array( 'recipes' => $recipes));
    }
    
    /**
     * @Route("/recipe/{id}", name="recipe_detail")
     */
    public function recipeDetailAction(Request $request, $id)
    {
        $recipe = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findOneByIdJoinedToFooditems($id);
        return $this->render('recipes/recipedetail.html.twig', array( 'recipe' => $recipe,
                                                                     'inCart' => Cart::currentCart($request)->hasRecipe($recipe->getId())));
    }
    
    /**
     * @Route("/saveRecipe", name="save_recipe")
     */
    public function saveRecipeAction(Request $request)
    {
        // TODO: ingredients need notes
        // TODO: should be able to type and see 1/3 rather than .3333
        // TODO: ingredients divided by sections?
        // TODO: recipe servings and times
        // TODO: disable enter on form
        // TODO: form validation (for name and things like that)
        
        
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
            
            $stepOrder = 1;
            foreach($data->steps as $stepDescription) {
                $step = new Step();
                $step->setDescription($stepDescription);
                $step->setPosition($stepOrder);
                $em->persist($step);
                
                $recipe->addStep($step);
                
                $stepOrder += 1;
            }
        }
        
        $em->flush();
        return new Response(json_encode(array('hello' => 'bob')));
    }
}
