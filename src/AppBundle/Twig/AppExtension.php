<?php

namespace AppBundle\Twig;

use Symfony\Component\HttpFoundation\Request;

class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('isActiveRoute',
                                     array($this, 'isActiveRoute'),
                                     array('needs_environment' => true)),
            new \Twig_SimpleFunction('areActiveRoutes',
                                     array($this, 'areActiveRoutes'),
                                     array('needs_environment' => true))
        );
    }
    
    public function isActiveRoute(\Twig_Environment $env, $route, $output = "active")
    {
        $request = $env->getGlobals()['app']->getRequest();
        if ($request->attributes->get('_route') == $route) return $output;
    }
    
    public function areActiveRoutes(\Twig_Environment $env, Array $routes, $output = "active")
    {
        $request = $env->getGlobals()['app']->getRequest();
        foreach ($routes as $route) {
            if ($request->attributes->get('_route') == $route) return $output;
        }
    }
    
    public function getName()
    {
        return 'app_extension';
    }
}