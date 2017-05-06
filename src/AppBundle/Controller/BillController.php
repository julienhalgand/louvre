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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BillController extends Controller
{
    /**
     * @Route("/bill/create", name="bill_create")
     * @Method({"POST"})
     */
    public function create(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormBill();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->get('app.bill_session_service')->saveInSession($form->getData());
            return $this->redirectToRoute('step2'); 
        }
        return $this->redirectToRoute('step1');
    }
    /**
     * @Route("/bill/addtickets", name="bill_addtickets")
     * @Method({"POST"})     
     */
    public function addTickets(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormTickets();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){           
            $this->get('app.bill_session_service')->saveInSession($form->getData());
            return $this->redirectToRoute('step3');
        }
        return $this->redirectToRoute('step2');
    }
    /**
     * @Route("/bill/deleteticket", name="bill_deleteticket")
     * @Method({"POST"})     
     */
    public function deleteTicket(Request $request)
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