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
        $billService = $this->get('app.bill_service');
        $formArray = $billService->renderForm('ticketsStep3Form');
        if(array_key_exists($id, $formArray)){
            $bill = $this->get('app.bill_session_service')->getBill();
            if($billService->countTickets($bill) > 1){
                $ticket = $formArray[$id]->getData();
                $bill->removeTicket($id);
                $this->get('app.bill_session_service')->saveInSession($bill);
            }
            return $this->redirectToRoute('step3');          
        }
        return new \notFoundException('Ticket not found.');
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
        return $this->render('pages/thankyou.html.twig', [
        ]);
    }
            
}