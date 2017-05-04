<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Service\FrenchHolidaysStringDateGenerator;

class ValidDateOfBookingValidator extends ConstraintValidator
{
    private $holidays;

    public function __construct(FrenchHolidaysStringDateGenerator $holidays){
        $this->holidays = $holidays;
    }

    public function validate($value, Constraint $constraint)
    {
        $dateNow = new \DateTime();
        $hourNow = $dateNow->format('d');
        $dateNow->setTime(0,0,0);
        //Jours fériés
        if($this->holidaysTest($value)){
            /*$this->context->buildViolation($constraint->message)
            ->addViolation();*/
        }
    }
    private function holidaysTest($value){
        $holidaysString = $this->holidays->getHolidaysString();
        foreach($holidaysString as $dateString){
            if ($value == new \DateTime($dateString)) return true;
        }
        return false;
    }
}