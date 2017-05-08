<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Service\TicketService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BillSessionService{
    private $request;
    private $normalizer;
    private $serializer;
    public function __construct(
        RequestStack $request
    ){
        $this->request = $request;
        $this->normalizer = array(new ObjectNormalizer());
        $this->serializer = new Serializer($this->normalizer, array(new JsonEncoder()));
    }
    /**
    * Test si Bill existe en session
    * @return bool
    */
    public function isBillInSession(){
        if($this->getCurrentSession()->get('Bill')){
            return true;
        }
        return false;
    }
    /**
    * Renvoi Bill depuis la session
    */
    public function getBill(){
        if($this->isBillInSession()){
            return $this->getCurrentSession()->get('Bill');
        }
        die("Pas de Bill en session");
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
        return $this->getCurrentSession()->set('Bill', clone $bill);
    }
    /**
    * Get current session
    * @return Session
    */
    private function getCurrentSession(){
        return $this->request->getCurrentRequest()->getSession();
    }
}