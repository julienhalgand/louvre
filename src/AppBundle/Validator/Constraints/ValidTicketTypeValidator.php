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
        $dateOfBooking = $bill->getDateOfBooking();
        $dateNow = new \DateTime();
        $dateNow->setTimeZone(new \DateTimeZone('Europe/Paris'));
        $dateNowHour = $dateNow->format('H');
        $dateNow->setTimeZone(new \DateTimeZone('UTC'));        
        $dateNow->setTime(0,0,0);
        $dateNow = $dateNow->format('d/m/Y');

        if($dateOfBooking == $dateNow){
            if ($dateNowHour >= Bill::HOUR_APPLY_HALF_JOURNEY_AFTER && $dateNowHour < Bill::HOUR_END_OF_THE_DAY && $value == Bill::TYPE_ALL_JOURNEY){
                $this->context->buildViolation('step1.allJourneyAfter14h')
                    ->addViolation();
            }elseif ($dateNowHour >= Bill::HOUR_END_OF_THE_DAY){
                $this->context->buildViolation('step1.toLateForReservationToday')
                    ->addViolation();
            }
        }
    }
}