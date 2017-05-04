<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Service\BillService;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\BillStep2Type;
use AppBundle\Form\BillStep3Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PagesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        return $this->render('pages/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/step1", name="step1")
     */
    public function step1Action(Request $request)
    {
        $form =$this->get('app.bill_service')->renderFormBill();
        if($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('step2'); 
        }
        return $this->render('pages/step1.html.twig', [
            'form'      => $form->createView(),
            'holidays'  => $this->container->get('app.holidays')->getHolidaysArrayString()
        ]);
    }
    /**
     * @Route("/step2", name="step2")
     */
    public function step2Action(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormTickets();
        if($form->isSubmitted() && $form->isValid()){
            //die(dump($form));
            return $this->redirectToRoute('step3');
        }
        return $this->render('pages/step2.html.twig', [
            'form'      => $form->createView(),
        ]);
    }
    /**
     * @Route("/step3", name="step3")
     */
    public function step3Action(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormDeleteTickets();
        $bill = $request->getSession()->get('Bill');
        return $this->render('pages/step3.html.twig', [
            'form'      => $form->createView(),
            'Bill'  => $bill
        ]);
    }
    /**
     * @Route("/thankyou", name="thankyou")
     */
    public function thankyouAction(Request $request)
    {
        return $this->render('pages/thankyou.html.twig', [
        ]);
    }
            
}