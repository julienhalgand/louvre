<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Service\TicketService;

class ValidReducedPriceValidator extends ConstraintValidator
{
    private $ticketService;

    public function __construct(TicketService $ticketService){
        $this->ticketService = $ticketService;
    }
    public function validate($value, Constraint $constraint)
    {
        $ticket = $this->context->getObject();
        if($this->ticketService->getAge($ticket) < 12 && $value){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}