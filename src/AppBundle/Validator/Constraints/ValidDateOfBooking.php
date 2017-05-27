<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidDateOfBooking extends Constraint
{
    public $message;
    public $groups;
    public function __construct(){
        $this->message = "This value is not valid.";
    }
    public function validateBy(){
        return "app.date_of_booking_validator";
    }
}