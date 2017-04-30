<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Bill;

use Symfony\Component\HttpFoundation\RequestStack;

class TicketManager{
    private $doctrine;
    private $form;
    private $request;

    public function __construct(
        RequestStack $request
    ){
        $this->request = $request;
    }
    /**
    * Crée un nouvel objet Ticket et rends sont formulaire
    */
    public function newTicket(){
        return new Ticket();
    }
    /**
    * Calcul et renvoi l'age
    */
    public function getAge(Ticket $ticket){
        return intval(strftime('%Y')) - intval($ticket->getDateOfBirthObject()->format('Y'));
    }
    /**
    * Régule le nombre de ticket en session en fonction du nombre désiré par l'utilisateur
    */ 
    public function ticketsRegulator(Bill $bill){
        $tickets = $bill->getTickets(); 
        $numberOfTickets = $bill->getNumberOfTickets();// Nombre de tickets désiré
        $numberOfTicketsInSession = count($tickets);//Nombre de tickets en session
        if($numberOfTickets != $numberOfTicketsInSession){
            if($numberOfTickets > $numberOfTicketsInSession){
                for($i=$numberOfTicketsInSession; $i < $numberOfTickets; $i++){
                    $newTicket = new Ticket();
                    $newTicket->setBill($bill);
                    $tickets->add($newTicket);
                }
            }
            if($numberOfTickets < $numberOfTicketsInSession){
                for($i=$numberOfTickets; $i < $numberOfTicketsInSession; $i++){
                    $tickets->remove($i);
                }
            }
        }
    }
}