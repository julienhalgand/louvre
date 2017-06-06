<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidNumberOfTickets extends Constraint
{
    public $message;
    public $groups;

    public function __construct(){
        $this->message = "This value is not valid.";
    }
}