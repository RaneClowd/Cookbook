<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    /**
     * @Route("/new", name="new_recipe")
     */
    public function newRecipeAction()
    {
        return $this->render('newrecipe.html.twig');
    }
}
