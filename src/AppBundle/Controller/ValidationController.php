<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ValidationController extends Controller
{
    /**
     * @Route("/validateStep1")
     */
    public function validateStep1Action()
    {
        return $this->render('AppBundle:Validation:validate_step1.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/validateStep2")
     */
    public function validateStep2Action()
    {
        return $this->render('AppBundle:Validation:validate_step2.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/validateStep3")
     */
    public function validateStep3Action()
    {
        return $this->render('AppBundle:Validation:validate_step3.html.twig', array(
            // ...
        ));
    }

}
