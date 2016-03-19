<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $recipeRepository = $this->getDoctrine()->getRepository('AppBundle:Recipe');
        $recipes = $recipeRepository->findAll();
        return $this->render('recipes/index.html.twig', array( 'recipes' => $recipes));
    }
}
