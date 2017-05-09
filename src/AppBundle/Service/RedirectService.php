<?php

namespace AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectService{
    private $router;    
    public function __construct(
        Router $router
    ){
        $this->router = $router;        
    }
    public function redirectToRoute(String $actionName, Array $params = null){
        return new RedirectResponse($this->router->generate($actionName, $params = array(), UrlGeneratorInterface::ABSOLUTE_PATH));
    }
}