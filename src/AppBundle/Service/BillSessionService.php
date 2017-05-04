<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Service\TicketService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Serializer;

class BillSessionService{
    private $request;
    private $serializer;
    public function __construct(
        RequestStack $request,
        Serializer $serializer
    ){
        $this->request = $request;
        $this->serializer = $serializer;
    }
    /**
    * Serialize Bill
    * @return json
    */
    private function serializeBill(){
        $serializedBill = $this->serializer->serialize(
            $this->bill,
            'json',
            ['groups' => ['tickets']]
        );
    }
    /**
    * deserialize Bill
    * @return Bill
    */
    private function deSerializeBill($serializedBill){
         $bill = $this->serializer->deserialize(
            $serializedBill,
            Bill::class,
            'json'
        );
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
        return false;
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
    /**
    * Get current session
    * @return Session
    */
    private function getCurrentSession(){
        return $this->request->getCurrentRequest()->getSession();
    }
}