<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
use AppBundle\Manager\TicketManager;

class TicketsSessionManager{
    private $session;
    private $tickets;

    public function __construct(
        RequestStack $request
    ){
        $this->session = $request->getSession();
        $this->tickets = $this->session->get('Bill')->getTickets();
    }
    /**
    * Test si des Ticket existent en session dans l'objet Bill
    * @return bool
    */
    public function isTicketsInSession(ArrayCollection $tickets){
        if(count($tickets) > 0){
            return true;
        }
        return false;
    }
}