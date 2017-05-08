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
     * @Route("/bill/deleteticket/{id}", name="bill_deleteticket")
     * @Method({"DELETE"})     
     */
    public function deleteTicket(Request $request, Int $id)
    {
        $billService = $this->get('app.bill_service');
        $formArray = $billService->renderFormDeleteTickets();
        if(array_key_exists($id, $formArray)){
            $formArray[$id]->handleRequest($request);
            $bill = $this->get('app.bill_session_service')->getBill();
            if($billService->countTickets($bill) > 1){
                $billService->deleteTicket($bill, $id);
                $this->get('app.bill_session_service')->saveInSession($bill);
            }
            return $this->redirectToRoute('step3');          
        }
        return new \notFoundException('Ticket not found.');
    }
    /**
     * @Route("/bill/comfirm", name="command_confirmation")
     * @Method({"POST"})     
     */
    public function comfirmCommand(Request $request)
    {
        $form = $this->get('app.bill_service')->renderFormConfirmCommand();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            die(dump($form));
        }        
        return $this->redirectToRoute('step3'); 
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