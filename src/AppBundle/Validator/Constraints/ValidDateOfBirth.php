<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidDateOfBirth extends Constraint
{
    public $message;

    public function __construct(){
        $this->message = "eeeeie,uie,";
    }
}