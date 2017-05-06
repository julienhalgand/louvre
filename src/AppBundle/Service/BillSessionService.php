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
    * Serialize Bill
    * @return json
    */
    private function serializeBill(Bill $bill){        
        return $this->serializer->serialize($bill, 'json');
    }
    /**
    * deserialize Bill
    * @return Bill
    */
    private function deSerializeBill($serializedBill){
        return $this->serializer->deserialize($serializedBill,Bill::class,'json');
    }
    /**
    * normalize Bill
    */
    private function normalizeBill(Bill $bill){
        $normalizer = new ObjectNormalizer();
        $normalizedBill = $this->serializer->normalize(
            $bill,
            Bill::class
        );
        return $bill;
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
            $bill = $this->deSerializeBill($this->getCurrentSession()->get('Bill'));
            return $bill;
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
        $serializedBill = $this->serializeBill($bill);
        //die(dump($serializedBill, $bill));
        return $this->getCurrentSession()->set('Bill', $serializedBill);
    }
    /**
    * Get current session
    * @return Session
    */
    private function getCurrentSession(){
        return $this->request->getCurrentRequest()->getSession();
    }
}