<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlannedController extends Controller
{
    /**
     * @Route("/planned", name="planned_recipes")
     */
    public function indexAction()
    {
        return $this->render('plannedRecipes.html.twig');
    }
}
