<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
use Doctrine\ORM\EntityManager;

class BillManager{
    private $doctrine;

    public function __construct(
        EntityManager $doctrine
    ){
        $this->doctrine = $doctrine;
    }

    public function create(Bill $bill){
        $bill->setTotalPrice(250);
        dump($bill);
        $this->doctrine->persist($bill);
        dump($bill);
        $this->doctrine->flush();
        return $bill;
    }

}