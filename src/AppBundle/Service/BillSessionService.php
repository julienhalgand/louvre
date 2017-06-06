<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Service\TicketService;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Exception\BillNotFoundException;

class BillSessionService{
    private $request;
    public function __construct(
        RequestStack $request
    ){
        $this->request = $request;
    }
    /**
    * Test si Bill existe en session
    * @return bool
    */
    public function testIfBillInSession(){
        if($this->getCurrentSession()->get('Bill')){
            return true;
        }
        return false;
    }

    /**
    * Renvoi Bill depuis la session
    */
    public function getBill(){
        $this->isBillInSession();
        return $this->getCurrentSession()->get('Bill');
    }

    /**
    * Sauvegarde l'objet Bill en session
    * @return Bill
    */
    public function saveInSession(Bill $bill){
        return $this->getCurrentSession()->set('Bill', $bill);
    }

    /**
     * New session if done
     * @return Bill
     */
    public function newSessionIfDone(Bill $bill){
        if($bill->getStep() === "done"){
            $this->getCurrentSession()->remove('Bill');
            return $this->getCurrentSession()->set('Bill', new Bill());
        }
    }

    /**
     * Test si Bill existe en session
     * @return BillNotFoundException
     */
    private function isBillInSession(){
        if(!$this->getCurrentSession()->get('Bill')){
            throw new BillNotFoundException();
        }
    }

    /**
     * Get current session
     * @return Session
     */
    private function getCurrentSession(){
        return $this->request->getCurrentRequest()->getSession();
    }
}