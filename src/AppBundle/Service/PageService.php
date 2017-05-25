<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Manager\BillManager;

class PageService{
    private $request;
    private $twig;
    private $redirectService;    
    private $billService;
    private $billSessionService;
    private $ticketService;
    private $holidaysService;
    private $stripeService;
    private $emailService;
    private $billManager;

    public function __construct(
        RequestStack                        $request,
        \Twig_Environment                   $twig,
        RedirectService                     $redirectService,    
        BillService                         $billService,
        BillSessionService                  $billSessionService,
        TicketService                       $ticketService,
        FrenchHolidaysStringDateGenerator   $holidaysService,
        StripeService                       $stripeService,
        EmailService                        $emailService,
        BillManager                         $billManager
    ){
        $this->request                    = $request;
        $this->twig                       = $twig;
        $this->redirectService            = $redirectService;
        $this->billService                = $billService;
        $this->billSessionService         = $billSessionService;
        $this->ticketService              = $ticketService;
        $this->holidaysService            = $holidaysService;
        $this->stripeService              = $stripeService;
        $this->emailService               = $emailService;
        $this->billManager                = $billManager;
    }
    public function renderView(String $nameOfView){
        if(is_callable(array($this, $nameOfView))){
            return $this->$nameOfView();
        }else{
            return $this->createNotFoundException('This view doesn\'t exist.');
        }
    }
    /**
     * @return Response
     */
    private function step1(){
        $form = $this->billService->renderForm('billStep1');
        if($form->isSubmitted() && $form->isValid()){
            $this->billSessionService->saveInSession($form->getData());
            return $this->redirectService->redirectToRoute('step2');
        }
        return new Response($this->twig->render('pages/step1.html.twig', [
            'form'          => $form->createView(),
            'holidays'      => $this->holidaysService->getHolidaysArrayString()
        ]));
    }
    /**
     * @return Response
     */
    private function step2(){
        $form = $this->billService->renderForm('billStep2');
        if($form->isSubmitted() && $form->isValid()){
            $bill = $form->getData();            
            $this->ticketService->setPrices($bill);            
            $this->billSessionService->saveInSession($bill);
            return $this->redirectService->redirectToRoute('step3');
        }
        return new Response($this->twig->render('pages/step2.html.twig', [
            'form'          => $form->createView()
        ]));
    }
    /**
     * @return Response
     */
    private function step3(){
        $form = $this->billService->renderForm('billStep3');
        $formsArray = $this->billService->renderForm('ticketsStep3');
        if($form->isSubmitted() && $form->isValid()){
            $bill = $form->getData();
            $this->billSessionService->saveInSession($bill);
            return $this->redirectService->redirectToRoute('payment');
        }
        return new Response($this->twig->render('pages/step3.html.twig', [
            'form'          => $form->createView(),
            'formsArray'    => $formsArray,
            'Bill'          => $this->billSessionService->getBill()
        ]));
    }

    /**
     * @return Response
     */
    private function stripe(){
        $form = $this->billService->renderForm('stripeForm');
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $charge = $this->stripeService->charge($data['stripe_token'],100);

            if(gettype($charge) == 'object'){
                $bill = $this->billSessionService->getBill();
                $bill->setStripeId(",eistc,ietci,ec");
                $this->billManager->create($bill);
                $this->billSessionService->saveInSession($bill);
                $mailMessage = $this->emailService->sendMail($bill);
                //#1
                return $this->redirectService->redirectToRoute('thankyou');
            }elseif (gettype($charge) == 'string'){
                $this->request->getCurrentRequest()->getSession()->getFlashBag()->add('alert',$charge);
            }else{
                //#2
            }
        }
        return new Response($this->twig->render('pages/stripe.html.twig', [
            'form'          => $form->createView(),
            'stripeApiKey' => $this->stripeService->getApiKey()
        ]));
    }
    /**
     * @return Response
     */
    private function thankyou(){
        $bill = $this->billSessionService->getBill();
        return new Response($this->twig->render('pages/stripe.html.twig', [
            'Bill' => $bill
        ]));
    }

    /**
     * @return Response
     */
    public function deleteTicket(){
        $formArray = $this->billService->renderForm('ticketsStep3Form');
        $bill = $this->billSessionService->getBill();
        if($bill->countTickets($bill) > 1){
            if($bill->removeTicket($id) != null){
                $this->billSessionService->saveInSession($bill);
                return $this->redirectService->redirectToRoute('step3');
            }
        }
        $this->request->getCurrentRequest()->getSession()->getFlashBag()->add('warning', 'step3.oneTicketAtLeast');
        return $this->redirectService->redirectToRoute('step3');
    }
}