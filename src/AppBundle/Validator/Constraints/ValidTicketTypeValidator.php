<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Entity\Bill;

class ValidTicketTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $bill = $this->context->getObject();
        $dateNow = new \DateTime();
        $hourNow = $dateNow->format('d');
        $dateNow->setTime(0,0,0);
        //Si passé 14h on change le type de billet pour halfJourney
        $dateOfBooking = $bill->getDateOfBooking();
        $dateNow = new \DateTime();
        $dateNow->setTimeZone(new \DateTimeZone('Europe/Paris'));
        $dateNowHour = $dateNow->format('H');
        $dateNow->setTimeZone(new \DateTimeZone('UTC'));        
        $dateNow->setTime(0,0,0);
        if($dateOfBooking == $dateNow && $dateNowHour >= Bill::HOUR_APPLY_HALF_JOURNEY_AFTER && $value == Bill::TYPE_ALL_JOURNEY){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
}