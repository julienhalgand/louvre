<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Service\BillSessionService;
use AppBundle\Service\TicketService;
use AppBundle\Service\TicketSessionService;
use Symfony\Component\Form\FormFactory;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\BillStep2Type;
use AppBundle\Form\BillStep3Type;
use AppBundle\Form\TicketStep3Type;
use Symfony\Component\HttpFoundation\RequestStack;

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
    public function newBill(){
        return new Bill();
    }
    /**
    * Rends le formulaire de Bill step1
    * @return FormFactory
    */
    public function renderFormBill(){
        $request = $this->request->getCurrentRequest();
        $bill = $this->newBill();
        if($this->billSessionService->isBillInSession()){
            $bill = $this->billSessionService->getBill();            
        }else{
            $this->billSessionService->saveInSession($bill);
        }
        $form = $this->form->create(BillStep1Type::class, $bill);
        return $form;
    }
    /**
    * Rends le formulaire de Tickets
    * @return FormFactory
    */
    public function renderFormTickets(){
        $request = $this->request->getCurrentRequest();
        $clonedSessionBill = clone $this->billSessionService->getBill();
        $this->ticketService->ticketsRegulator($clonedSessionBill); //Régule le nombre de ticket en session
        $form = $this->form->create(BillStep2Type::class, $clonedSessionBill);
        return $form;
    }
    public function renderFormDeleteTicketsView(){
        $request = $this->request->getCurrentRequest();       
        $bill = $this->billSessionService->getBill();
        $formsArray = [];
        foreach($bill->getTickets() as $ticket){
            $formsArray[] = $this->form->create(TicketStep3Type::class, $ticket)->createView();
        }
        return $formsArray;
    }
    public function renderFormConfirmCommand(){
        $request = $this->request->getCurrentRequest();       
        $bill = $this->billSessionService->getBill();
        $form = $this->form->create(BillStep3Type::class, $bill);
        return $form;
    }
    public function renderFormDeleteTickets(){
        $request = $this->request->getCurrentRequest();       
        $bill = $this->billSessionService->getBill();
        $formsArray = [];
        foreach($bill->getTickets() as $ticket){
            $formsArray[] = $this->form->create(TicketStep3Type::class, $ticket);
        }
        return $formsArray;
    }
    /**
    * Ajoute un Ticket à Bill
    * @return Bill
    */
    public function addTickets(Bill $bill, $numberOfTickets = null){
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
    * Supprime un Ticket à Bill
    * @return Bill
    */
    public function deleteTicket(Bill $bill, Int $key){
        $tickets = $bill->getTickets();
        $tickets->remove($key);
        $bill->setNumberOfTickets($bill->getNumberOfTickets()-1);
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