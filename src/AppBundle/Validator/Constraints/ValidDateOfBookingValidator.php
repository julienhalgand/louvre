<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Service\FrenchHolidaysStringDateGenerator as v;

class ValidDateOfBookingValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $dateNow = new \DateTime();
        $hourNow = $dateNow->format('d');
        $dateNow->setTime(0,0,0);
        //Jours fériés
        if(self::holidaysTest($value)){
            $this->context->buildViolation($constraint->message)
            ->addViolation();
        }
    }
    private static function holidaysTest($value){
        $holidaysString = v::getHolidaysString();
        foreach($holidaysString as $dateString){
            if ($value == new \DateTime($dateString)) return true;
        }
        return false;
    }
}