<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\CreditCard;
use AppBundle\Service\BillSessionService;
use AppBundle\Service\TicketService;
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
    * Crée un nouvel objet Bill
    */
    private function newBill(){
        return new Bill();
    }
    /**
    * Rends un formulaire
    */
    public function renderForm(String $nameOfForm){
        if(is_callable(array($this, $nameOfForm))){
            return $this->$nameOfForm();
        }else{
            return $this->createNotFoundException('This view doesn\'t exist.');
        }
    }
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
    * Rends le formulaire de Bill step1
    * @return FormFactory
    */
    private function billStep1(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->createBillIfNotInSession();
        $form = $this->form->create(BillStep1Type::class, $bill);
        $form->handleRequest($request);
        return $form;
    }
    /**
    * Rends le formulaire de Tickets
    * @return FormFactory
    */
    private function billStep2(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $this->ticketService->ticketsRegulator($bill); //Régule le nombre de ticket en session
        $form = $this->form->create(BillStep2Type::class, $bill);
        $form->handleRequest($request);
        return $form;
    }
    private function billStep3(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->billSessionService->getBill();
        $form = $this->form->create(BillStep3Type::class, $bill);
        $form->handleRequest($request);        
        return $form;
    }
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
    private function stripeForm(){
        $request = $this->request->getCurrentRequest();
        $form = $this->form->create(CreditCardPaymentType::class);
        $form->handleRequest($request);        
        return $form;
    }

    /**
    * Ajoute un Ticket à Bill
    * @return Bill
    */
    private function addTickets(Bill $bill, $numberOfTickets = null){
        if($numberOfTickets = null){
            $bill->getTickets()->add($ticketService->newTicket());
            return $bill;
        }
        for($i=0; $i<$bill->getNumberOfTickets();$i++){
            if(count($bill->getTickets()) < $bill->getNumberOfTickets()){
                $bill->getTickets()->add($ticketService->newTicket());              
            }
        }
        return $bill; 
    }
    /**
    * Compte les tickets dans bill
    * @return int
    */
    public function countTickets(Bill $bill){
        $tickets = $bill->getTickets();
        
        return count($tickets);;
    }

}