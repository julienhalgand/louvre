<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bill;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class BillManager{
    private $doctrine;
    private $validator;

    public function __construct(
        EntityManager $doctrine,
        RecursiveValidator $validator
    ){
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    public function create(Bill $bill){
        $this->doctrine->persist($bill);
        $this->doctrine->flush();
        return $bill;
    }

    public function validate(Bill $bill){
        $errors = $this->validator->validate($bill);
            return $errors;
    }

}