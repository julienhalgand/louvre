<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Manager\BillManager;
use AppBundle\Entity\Bill;

class ValidNumberOfTicketsValidator extends ConstraintValidator
{
    private $billManager;

    public function __construct(BillManager $billManager){
        $this->billManager = $billManager;
    }
    public function validate($value, Constraint $constraint)
    {
        $bill = $bill = $this->context->getObject();
        $numberOfTicketsAvailable = $this->billManager->countNumberOfTicketsAvailableWithDateOfBooking($bill);
        if($numberOfTicketsAvailable < $value){
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}