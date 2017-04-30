<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
use AppBundle\Manager\TicketManager;
use Symfony\Component\HttpFoundation\RequestStack;


class BillSessionManager{
    private $session;
    private $bill;

    public function __construct(
        RequestStack $request
    ){
        $this->session = $request->getCurrentRequest()->getSession();
        $this->bill = $request->getCurrentRequest()->getSession()->get('Bill');
    }
    /**
    * Test si Bill existe en session
    * @return bool
    */
    public function isBillInSession(){
        if($this->bill){
            return true;
        }
        return false;
    }
    /**
    * Renvoi Bill depuis la session
    */
    public function getBill(){
        return $this->bill;
    }
    /**
    * Compte le nombre de Tickets dans la session
    * @return int
    */
    public function getNumberOfTicketsInSession(Bill $bill){
       return count($bill->getNumberOfTickets());
    }
    /**
    * Sauvegarde l'objet Bill en session
    * @return Session
    */
    public function saveInSession(Bill $bill){
       return $this->session->set('Bill', $bill);
    }
}