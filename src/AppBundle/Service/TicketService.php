<?php

namespace AppBundle\Service;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

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
    * Test si des Ticket existent en session dans l'objet Bill
    * @return bool
    */
    public function testIfTickets($tickets){
        if(count($tickets) > 0){
            return true;
        }
        return false;
    }
    /**
    * Test si des Ticket existent en session dans l'objet Bill
    * @return TicketsNotFoundException
    */
    public function isTickets($tickets){
        if(count($tickets) === 0){
            throw new TicketsNotFoundException();
        }
    }
    /**
    * Compte le nombre de Tickets dans la session
    * @return int
    */
    public function getNumberOfTickets($tickets){
        $this->isTicketsInSession();
        return count($bill->getNumberOfTickets());
    }
    /**
    * Calcul et renvoi l'age
    */
    public function getAge(Ticket $ticket){
        $dateDifference = date_diff(new \DateTime(),$ticket->getDateOfBirthObject());
        return $dateDifference->format('Y');
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
    /**
    * Calcul et set les prix des billets
    * @return Bill
    */
    public function setPrices(Bill $bill){
        $tickets = $bill->getTickets();
        foreach($tickets as $ticket){
            $age            = $this->getAge($ticket);
            $ticketPrice    = Ticket::PRICE_NORMAL;
            $priceType      = Ticket::PRICE_TYPE_NORMAL;
            if($age > Ticket::AGE_SENIOR){
                $ticketPrice = Ticket::PRICE_SENIOR;
                $priceType      = Ticket::PRICE_TYPE_SENIOR;
            }elseif($age < Ticket::AGE_CHILD && $age > Ticket::AGE_YOUNG_CHILD){
                $ticketPrice = Ticket::PRICE_CHILD;
                $priceType      = Ticket::PRICE_TYPE_CHILD;
            }elseif($age < Ticket::AGE_YOUNG_CHILD){
                $ticketPrice = Ticket::PRICE_YOUNG_CHILD;
                $priceType      = Ticket::PRICE_TYPE_YOUNG_CHILD;
            }
            if($ticket->getReducedPrice() && $age > Ticket::AGE_CHILD){
                $ticketPrice = Ticket::PRICE_REDUCED;
                $priceType      = Ticket::PRICE_TYPE_REDUCED;
            }else{
                $ticket->setReducedPrice(false);
            }
            if($bill->getTicketType() == Bill::TYPE_HALF_JOURNEY && $ticketPrice != Ticket::PRICE_YOUNG_CHILD){
                $ticketPrice /= Ticket::PRICE_REDUCED_DIVIDED_BY;
            }
            $ticket->setPrice($ticketPrice);
            $ticket->setPriceType($priceType);
            $bill->setTotalPrice($bill->getTotalPrice()+$ticketPrice);
        }
        return $bill;
    }
    public function deleteTicket(Request $request, Int $id)
    {
        $billService = $this->get('app.bill_service');
        $formArray = $billService->renderFormDeleteTickets();
        if(array_key_exists($id, $formArray)){
            $formArray[$id]->handleRequest($request);
            $bill = $this->get('app.bill_session_service')->getBill();
            if($billService->countTickets($bill) > 1){
                $billService->deleteTicket($bill, $id);
                $this->get('app.bill_session_service')->saveInSession($bill);
            }
            return $this->redirectToRoute('step3');          
        }
        return new \notFoundException('Ticket not found.');
    }
}