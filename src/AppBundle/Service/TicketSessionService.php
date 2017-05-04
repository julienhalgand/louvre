<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Service\TicketService;
use Symfony\Component\HttpFoundation\RequestStack;

class TicketSessionService{
    private $tickets;

    public function __construct(
        RequestStack $request
    ){
        $this->request = $request;
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