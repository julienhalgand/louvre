<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use AppBundle\Service\BillService;
use AppBundle\Service\FrenchHolidaysStringDateGenerator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageService{
    private $request;
    private $twig;
    private $redirectService;    
    private $billService;
    private $billSessionService;
    private $holidaysService;
    public function __construct(
        RequestStack $request,
        \Twig_Environment $twig,        
        RedirectService $redirectService,    
        BillService $billService,
        BillSessionService $billSessionService,
        FrenchHolidaysStringDateGenerator $holidaysService
    ){
        $this->request = $request;
        $this->twig = $twig;
        $this->redirectService = $redirectService;        
        $this->billService = $billService;
        $this->billSessionService = $billSessionService;
        $this->holidaysService = $holidaysService;
    }
    public function renderView(String $nameOfView){
        if(is_callable(array($this, $nameOfView))){
            return $this->$nameOfView();
        }else{
            return $this->createNotFoundException('This view doesn\'t exist.');
        }
    }
    private function step1(){
        $form = $this->billService->renderForm('billStep1');
        if($form->isSubmitted() && $form->isValid()){
            $this->billSessionService->saveInSession($form->getData());
            return $this->redirectService->redirectToRoute('step2');
        }
        return new Response($this->twig->render('pages/step1.html.twig', [
            'form'      => $form->createView(),
            'holidays'  => $this->holidaysService->getHolidaysArrayString()
        ]));
    }
    private function step2(){
        $form = $this->billService->renderForm('billStep2');
        if($form->isSubmitted() && $form->isValid()){
            $this->billSessionService->saveInSession($form->getData());
            return $this->redirectService->redirectToRoute('step3');
        }
        return new Response($this->twig->render('pages/step2.html.twig', [
            'form'      => $form->createView()
        ]));
    }
    private function step3(){
        $form = $this->billService->renderForm('billStep3');
        $formsArray = $this->billService->renderForm('ticketsStep3');
        if($form->isSubmitted() && $form->isValid()){
            if($this->request->getCurrentRequest()->getMethod() == "DELETE"){

            }
            $this->billSessionService->saveInSession($form->getData());
            return $this->redirectService->redirectToRoute('payment');
        }
        return new Response($this->twig->render('pages/step3.html.twig', [
            'form'          => $form->createView(),
            'formsArray'    => $formsArray,
            'Bill'          => $this->billSessionService->getBill()
        ]));
    }
    private function thankyou(){
        
    }
}