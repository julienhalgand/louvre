<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Bill;


class ValidationController extends Controller
{
    /**
     * @Route("/validateStep1")
     */
    public function validateStep1Action(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $bill = new Bill();
            $bill->setDateOfBooking(new \DateTime($request->request->get('date_of_booking')));
            
            die(dump($form));
        }
        return 0;
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
