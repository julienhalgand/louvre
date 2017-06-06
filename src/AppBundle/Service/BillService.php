<?php

namespace AppBundle\Service;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Bill;
use AppBundle\Service\TicketSessionService;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\BillStep2Type;
use AppBundle\Form\BillStep3Type;
use AppBundle\Form\TicketStep3Type;
use AppBundle\Form\CreditCardPaymentType;

class BillService{
    private $form;
    private $request;
    private $billSessionService;
    private $ticketService;

    public function __construct(
        FormFactory $form,
        RequestStack $request,
        BillSessionService $billSessionService,
        TicketService $ticketService

    ){
        $this->form = $form;
        $this->request = $request;
        $this->billSessionService = $billSessionService;
        $this->ticketService = $ticketService;
    }

    /**
     * @param String $nameOfForm
     * @return mixed
     */
    public function renderForm(String $nameOfForm){
        if(is_callable(array($this, $nameOfForm))){
            return $this->$nameOfForm();
        }else{
            return $this->createNotFoundException('This view doesn\'t exist.');
        }
    }

    /**
     * @return Bill
     */
    private function createBillIfNotInSession(){
        $bill = $this->newBill();
        if($this->billSessionService->testIfBillInSession()){
            $bill = $this->billSessionService->getBill();            
        }else{
            $this->billSessionService->saveInSession($bill);
        }
        return $bill;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function billStep1(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->createBillIfNotInSession();
        $this->billSessionService->newSessionIfDone($bill);
        $form = $this->form->create(BillStep1Type::class, $bill);
        $form->handleRequest($request);
        return $form;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function billStep2(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $this->ticketService->ticketsRegulator($bill); //Régule le nombre de ticket en session
        $form = $this->form->create(BillStep2Type::class, $bill);
        $form->handleRequest($request);
        return $form;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function billStep3(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $form = $this->form->create(BillStep3Type::class, $bill);
        $form->handleRequest($request);        
        return $form;
    }

    /**
     * @return array
     */
    private function ticketsStep3(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $tickets = $bill->getTickets();
        $this->ticketService->isTickets($tickets);        
        $formsArray = [];
        foreach($tickets as $ticket){
            $form = $this->form->create(TicketStep3Type::class, $ticket);
            $form->handleRequest($request);
            $formsArray[] = $form->createView();
        }
        return $formsArray;
    }

    /**
     * @return array
     */
    private function ticketsStep3Form(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $tickets = $bill->getTickets();
        $this->ticketService->isTickets($tickets);        
        $formsArray = [];
        foreach($tickets as $ticket){
            $form = $this->form->create(TicketStep3Type::class, $ticket);            
            $formsArray[] = $form->handleRequest($request);
        }
        return $formsArray;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function stripeForm(){
        $request = $this->request->getCurrentRequest();
        $this->billSessionService->getBill();
        $form = $this->form->create(CreditCardPaymentType::class);
        $form->handleRequest($request);        
        return $form;
    }
    /**
     * @return Bill
     */
    private function newBill(){
        return new Bill();
    }

}