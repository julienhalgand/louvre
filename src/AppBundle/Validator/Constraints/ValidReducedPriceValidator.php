<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Manager\TicketManager as v;

class ValidReducedPriceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $ticket = $this->context->getObject();
        if(v::getAge($ticket) < 12 && $value){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}