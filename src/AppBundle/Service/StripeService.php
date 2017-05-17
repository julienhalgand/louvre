<?php

namespace AppBundle\Service;



class StripeService{
    private $stripeApiKey;
    public function __construct(
        Array                               $stripe
    ){
        $this->stripeApiKey               = $stripe['api_key'];
    }
    public function getApiKey(){
        return $this->stripeApiKey;
    }
}