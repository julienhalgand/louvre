<?php

namespace AppBundle\Manager;

use AppBundle\Entity\{
    Bill, Ticket
};
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class BillManager{
    private $doctrine;

    public function __construct(
        EntityManager $doctrine
    ){
        $this->doctrine = $doctrine;
    }

    public function create(Bill $bill){
        $this->doctrine->persist($bill);
        //dump($bill);
        $this->doctrine->flush();
        return $bill;
    }

    public function countNumberOfTicketsAvailableWithDateOfBooking(Bill $bill){
        $dateOfBooking = $bill->getDateOfBooking();
        $queryBuilder = $this->doctrine->getRepository('AppBundle:Bill')->createQueryBuilder('bill')
        ->select('bill.numberOfTickets')
        ->where('bill.dateOfBooking > :dateOfBooking')
            ->setParameter('dateOfBooking', $dateOfBooking)
            ->getQuery();
        $totalNumberOfTickets = 0;
        $billsArray = $queryBuilder->getResult();
        foreach ($billsArray as $bill){
            $totalNumberOfTickets += $bill['numberOfTickets'];
        }
        return Ticket::MAX_NUMBER_OF_TICKETS_PER_DAY -  $totalNumberOfTickets;
    }
}