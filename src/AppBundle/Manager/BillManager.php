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
        $this->doctrine->persist($bill);
        $this->doctrine->flush();
        return $bill;
    }

}