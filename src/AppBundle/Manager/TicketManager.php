<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Bill;
use Doctrine\ORM\EntityManager;

use AppBundle\Manager\TicketSessionManager;

use Symfony\Component\HttpFoundation\RequestStack;

class TicketManager{
    private $doctrine;
    private $request;

    public function __construct(
        EntityManager $doctrine,
        RequestStack $request
    ){
        $this->doctrine = $doctrine;
        $this->request = $request;
    }
}