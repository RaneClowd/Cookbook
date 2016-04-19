<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Recipe;
use AppBundle\ViewEntity\RecipeChecker;
use AppBundle\Entity\Step;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\FoodItem;
use AppBundle\ViewEntity\Cart;
use AppBundle\ViewEntity\MeasureConverter;

class RecipeController extends Controller
{
    /**
     * @Route("/new", name="new_recipe")
     */
    public function newRecipeAction()
    {
        $measures = [];
        foreach(MeasureConverter::allMeasureClasses() as $measureTypeClass) {
            array_push($measures, new $measureTypeClass());
        }
        return $this->render('alterRecipe.html.twig', array( 'measureArray' => $measures, 'recipe' => new Recipe()));
    }
    
    /**
     * @Route("/edit/{id}", name="edit_recipe")
     */
    public function editRecipeAction($id)
    {
        $measures = [];
        foreach(MeasureConverter::allMeasureClasses() as $measureTypeClass) {
            array_push($measures, new $measureTypeClass());
        }
        
        $recipe = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findOneByIdJoinedToFoodItems($id);
        
        return $this->render('alterRecipe.html.twig', array( 'measureArray' => $measures, 'recipe' => $recipe));
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
        return $this->render('recipes/recipedetail.html.twig', array( 'recipe' => $recipe, 'inCart' => Cart::currentCart($request)->hasRecipe($recipe->getId())));
    }
    
    /**
     * @Route("/update/{id}", name="update_recipe")
     */
    public function updateRecipeAction(Request $request, $id)
    {
        $content = $request->getContent();
        if ( !empty($content)) {
            $data = json_decode($content);
        
            $em = $this->getDoctrine()->getManager();
            $recipe = $em->getRepository('AppBundle:Recipe')->findOneByIdJoinedToFooditems($id);

            $recipe->setName($data->name);
            $recipe->setSource($data->source);

            $checker = new RecipeChecker($recipe);
            $checker->checkForIngredients($data->ingredients);
            $checker->checkForSteps($data->steps);
            
            foreach ($checker->getIngredientsNeeded() as $ingredient) {
                $em->persist($ingredient);
                $em->persist($ingredient->getFoodItem());
                $recipe->addIngredient($ingredient);
            }
            foreach ($checker->getIngredientsToRemove() as $ingredient) {
                $recipe->removeIngredient($ingredient);
                $em->remove($ingredient);
            }
            foreach ($checker->getStepsNeeded() as $step) {
                $em->persist($step);
                $recipe->addStep($step);
            }
            foreach ($checker->getStepsToRemove() as $step) {
                $recipe->removeStep($step);
                $em->remove($step);
            }
            
            $em->flush();
        }
        
        return new Response(json_encode('bob'));
    }
    
    /**
     * @Route("/saveRecipe", name="save_recipe")
     */
    public function saveRecipeAction(Request $request)
    {
        // TODO: should be able to type and see 1/3 rather than .3333
        // TODO: recipe servings and times
        // TODO: disable enter on form
        // TODO: form validation (for name and things like that)
        
        
        $em = $this->getDoctrine()->getManager();
        
        $content = $request->getContent();
        if ( !empty($content)) {
            $data = json_decode($content);
            
            $recipe = new Recipe();
            $recipe->setName($data->name);
            $recipe->setSource($data->source);
            $em->persist($recipe);
            
            foreach($data->ingredients as $dataItem) {
                $foodItem = new FoodItem();
                $foodItem->setName($dataItem->name);
                $em->persist($foodItem);
                
                $ingredient = new Ingredient();
                
                if (isset($dataItem->unit)) {
                    $ingredient->setUnit($dataItem->unit);
                }
                    
                $ingredient->setAmount($dataItem->amount);
                $ingredient->setNote($dataItem->note);
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
        return new Response(json_encode('bob'));
    }
}
