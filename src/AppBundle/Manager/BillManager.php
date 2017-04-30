<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
use AppBundle\Manager\BillSessionManager;
use AppBundle\Entity\Ticket;
use AppBundle\Manager\TicketManager;
use AppBundle\Manager\TicketSessionManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\BillStep2Type;
use Symfony\Component\HttpFoundation\RequestStack;

class BillManager{
    private $doctrine;
    private $form;
    private $request;
    private $ticketManager;

    public function __construct(
        EntityManager $doctrine,
        FormFactory $form,
        RequestStack $request
    ){
        $this->doctrine = $doctrine;
        $this->form = $form;
        $this->request = $request;
        $this->billSessionManager = new BillSessionManager($request);
        $this->ticketManager = new TicketManager($request);
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
        if($this->billSessionManager->isBillInSession()){
            $bill = $this->billSessionManager->getBill();            
        }else{
            $this->billSessionManager->saveInSession($bill);
        }
        $form = $this->form->create(BillStep1Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
        if($this->billSessionManager->isBillInSession()){
            $request->getSession()->getFlashBag()->add(
                'warning','aieu'
                //$this->get('translator')->trans('step1NotValid')
            );
            //return $this->redirectToRoute('step1'); 
        }
        $bill = $this->billSessionManager->getBill();
        $this->ticketManager->ticketsRegulator($bill);//Régule le nombre de ticket en session
        $form = $this->form->create(BillStep2Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //die(dump($bill));
            /*foreach($tickets as $ticket){
                $ticketPrice = $ticket->getTicketPrice($bill->getTicketType());
                $ticket->setPrice($ticketPrice);
            }*/
            $request->getSession()->set('Bill', $bill);                           
        }
        return $form;
    }
    /**
    * Ajoute un Ticket à Bill
    * @return Bill
    */
    public function addTickets(Bill $bill, $numberOfTickets = null){
        if($numberOfTickets = null){
            $bill->getTickets()->add($ticketManager->newTicket());
            return $bill;
        }
        for($i=0; $i<$bill->getNumberOfTickets();$i++){
            if(count($bill->getTickets()) < $bill->getNumberOfTickets()){
                $bill->getTickets()->add($ticketManager->newTicket());              
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