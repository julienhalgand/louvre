<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Controller\ValidationController as v;

class ValidDateOfBookingValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $dateNow = new \DateTime();
        $hourNow = $dateNow->format('d');
        $dateNow->setTime(0,0,0);
        //Si date est inférieur à la date d'aujourd'hui et inférieur à date d'aujourd'hui+1 an
        if ($dateNow > $value || $dateNow->modify('+1 year') < $value){
            $this->context->buildViolation($constraint->message)
            //->setParameter('{{string}}', $value->format('Y-m-d'))
            ->addViolation();
        }
        //Jours fériés
        if(self::holidaysTest($value)){
            $this->context->buildViolation($constraint->message)
            //->setParameter('{{string}}', $value->format('Y-m-d'))
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