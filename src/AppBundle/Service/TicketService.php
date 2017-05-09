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
    private function getAge(Ticket $ticket){
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
    /**
    * Calcul et set les prix des billets
    * @return Bill
    */
    public function setPrices(Bill $bill){
        $tickets = $bill->getTickets();
        foreach($tickets as $ticket){
            //Calcul des prix
            $normalPrice            = 16;
            $senoirPrice            = 12;
            $childPrice             = 8;
            $reducedPriceDividedBy  = 2;
            //calcul de l'age
            $age            = $this->getAge();

            $ticketPrice    = 16;
            if($age > 60){
                $ticketPrice = 12;
            }elseif($age < 12 && $age > 4){
                $ticketPrice = 8;
            }elseif($age < 4){
                $ticketPrice = 0;
            }
            if($ticket->getReducedPrice() && $age > 12 && $age < 60){
                $ticketPrice = 10;
            }else{
                $ticket->setReducedPrice(false);
            }
            if($bill->getTicketType() == "halfJourney" && $ticketPrice != 0){
                $ticketPrice /= 2;
            }
            $ticket->setPrice($ticketPrice);
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