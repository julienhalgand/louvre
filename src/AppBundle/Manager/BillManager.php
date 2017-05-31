<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
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
        $this->doctrine->flush();
        return $bill;
    }

    public function countNumberOfTicketsAvailableWithDateOfBooking(Bill $bill){
        $dateOfBooking = $bill->getDateOfBooking();
        $queryBuilder = $this->doctrine->getRepository('AppBundle:Ticket')->createQueryBuilder('bill');
        $queryBuilder->select('bill.id');
        $queryBuilder->where('bill.dateOfBooking = :dateOfBooking');
        $queryBuilder->setParameter('dateOfBooking', $dateOfBooking);
        return $queryBuilder->getQuery()->getSingleScalarResult() - 1000;
    }
}