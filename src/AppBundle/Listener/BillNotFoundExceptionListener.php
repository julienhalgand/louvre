<?php
namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use AppBundle\Exception\BillNotFoundException;
use AppBundle\Exception\TicketsNotFoundException;
use AppBundle\Service\RedirectService;

class BillNotFoundExceptionListener
{
    private $redirectService;
    public function __construct(
        RedirectService $redirectService
    ){
        $this->redirectService = $redirectService;
    }
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        if ($exception instanceof BillNotFoundException) {            
            $event->setResponse($this->redirectService->redirectToRoute('step1'));
        }elseif ($exception instanceof TicketsNotFoundException){
            $event->setResponse($this->redirectService->redirectToRoute('step2'));            
        }
    }
}