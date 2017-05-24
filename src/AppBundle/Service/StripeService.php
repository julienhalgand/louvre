<?php

namespace AppBundle\Service;
use \Stripe\Stripe;
use \Stripe\Charge;


class StripeService{
    private $stripeApiKey;
    private $stripeApiKeyPrivate;
    private $stripe;
    private $charge;
    public function __construct(
        Array                               $stripe
    ){
        $this->stripeApiKey               = $stripe['api_key'];
        $this->stripeApiKeyPrivate        = $stripe['api_key_private'];
        $this->stripe                     = new Stripe();
        $this->charge                     = new Charge();
    }
    public function getApiKey(){
        return $this->stripeApiKey;
    }

    public function charge($token, $totalPrice){
        $this->stripe->setApiKey($this->stripeApiKeyPrivate);
        try {
            return $this->charge->create(array(
                "amount" => $totalPrice * 100,
                "currency" => "EUR",
                "source" => $token,
                "description" => "First test charge!"
            ));
        }catch (\Stripe\Error\InvalidRequest $exception){
            return $exception->getMessage();
        }catch (\Stripe\Error\Authentication $exception){
            return $exception->getMessage();
        }catch (\Stripe\Error\Card $exception){
            return $exception->getMessage();
        }catch (\Stripe\Error\Permission $exception){
            return $exception->getMessage();
        }catch (\Stripe\Error\RateLimit $exception){
            return $exception->getMessage();
        }catch (\Stripe\Error\Api $exception){
            return $exception->getMessage();
        }catch (\Exception $exception){
            return $exception->getMessage();
        };
    }
}