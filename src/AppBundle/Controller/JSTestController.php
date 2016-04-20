<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JSTestController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function indexAction()
    {
        return $this->render('test.html.twig');
    }
}
