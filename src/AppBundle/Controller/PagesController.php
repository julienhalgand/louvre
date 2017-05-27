<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Service\PageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Method({"GET","HEAD","POST"})
     */
    public function step1Action(Request $request){
        return $this->get('app.page_service')->renderView('step1');
    }
    /**
     * @Route("/step2", name="step2")
     * @Method({"GET","HEAD","POST"})
     */
    public function step2Action(Request $request){
        return $this->get('app.page_service')->renderView('step2');
    }
    /**
     * @Route("/step3", name="step3")
     * @Method({"GET","HEAD","POST","DELETE"})
     */
    public function step3Action(Request $request){
        return $this->get('app.page_service')->renderView('step3');
    }
    /**
     * @Route("/bill/deleteticket/{id}", name="bill_deleteticket")
     * @Method({"DELETE"})     
     */
    public function deleteTicket(Request $request, Int $id)
    {
        return $this->get('app.page_service')->deleteTicket();

    }
    /**
     * @Route("/payment", name="payment")
     * @Method({"GET","HEAD","POST"})
     */
    public function stripeAction(Request $request)
    {
        return $this->get('app.page_service')->renderView('stripe');
    }
    /**
     * @Route("/thankyou", name="thankyou")
     * @Method({"GET","HEAD"})
     */
    public function thankyouAction(Request $request)
    {
        return $this->get('app.page_service')->renderView('thankyou');
    }
            
}