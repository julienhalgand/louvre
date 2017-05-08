<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Service\PageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PagesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET","HEAD"})
     */
    public function homepageAction(Request $request)
    {
        return $this->render('pages/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/step1", name="step1")
     * @Method({"GET","HEAD"})
     */
    public function step1Action(Request $request)
    {
        return $this->get('app.page_service')->renderView('step1');
    }
    /**
     * @Route("/step2", name="step2")
     * @Method({"GET","HEAD"})
     */
    public function step2Action(Request $request)
    {
        return $this->get('app.page_service')->renderView('step2');
    }
    /**
     * @Route("/step3", name="step3")
     * @Method({"GET","HEAD"})
     */
    public function step3Action(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormConfirmCommand()->createView();
        $formsArray = $this->get('app.bill_service')->renderFormDeleteTicketsView();
        $bill = $request->getSession()->get('Bill');
        return $this->render('pages/step3.html.twig', [
            'form'          => $form,
            'formsArray'    => $formsArray,
            'Bill'          => $bill
        ]);
    }
    /**
     * @Route("/thankyou", name="thankyou")
     * @Method({"GET","HEAD"})
     */
    public function thankyouAction(Request $request)
    {
        return $this->render('pages/thankyou.html.twig', [
        ]);
    }
            
}