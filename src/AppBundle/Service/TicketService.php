<?php

namespace AppBundle\Service;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Bill;
use Doctrine\ORM\EntityManager;

use AppBundle\Service\TicketSessionService;

use Symfony\Component\HttpFoundation\RequestStack;

class TicketService{
    private $doctrine;
    private $request;

    public function __construct(
        EntityManager $doctrine,
        RequestStack $request
    ){
        $this->doctrine = $doctrine;
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
        return $bill;
    }
}