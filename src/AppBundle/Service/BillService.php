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
        return new Bill();;
    }
    /**
    * Rends le formulaire de Bill
    * @return FormFactory
    */
    public function renderFormBill(){
        $request = $this->request->getCurrentRequest();
        $bill = new Bill();
        if($this->billSessionService->isBillInSession()){
            $bill = $this->billSessionService->getBill();            
        }else{
            $this->billSessionService->saveInSession($bill);
        }
        $form = $this->form->create(BillStep1Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $billSerialized = 
            $request->getSession()->set('Bill', $bill);                           
        }
        return $form;
    }
    /**
    * Rends le formulaire de Tickets
    * @return FormFactory
    */
    public function renderFormTickets(){
        $request = $this->request->getCurrentRequest();
        //Test si objet ticket existe en session
        if($this->billSessionService->isBillInSession()){
            $request->getSession()->getFlashBag()->add(
                'warning','aieu'
                //$this->get('translator')->trans('step1NotValid')
            );
            //return $this->redirectToRoute('step1'); 
        }
        $bill = $this->billSessionService->getBill();
        $this->ticketService->ticketsRegulator($bill);//Régule le nombre de ticket en session
        $form = $this->form->create(BillStep2Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //die(dump($bill));
            /*foreach($tickets as $ticket){
                $ticketPrice = $ticket->getTicketPrice($bill->getTicketType());
                $ticket->setPrice($ticketPrice);
            }*/                         
        }
        return $form;
    }
    public function renderFormDeleteTickets(){
        $request = $this->request->getCurrentRequest();
        
        $bill = $this->billSessionService->getBill();
        $form = $this->form->create(BillStep3Type::class, $bill);
        $form->handleRequest($request);
        return $form;
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
    * Compte les tickets dans bill
    * @return int
    */
    public function countTickets(Bill $bill){
       return $bill->getNumberOfTickets();
    }

}