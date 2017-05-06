<?php

namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Service\BillService;
use AppBundle\Service\FrenchHolidaysStringDateGenerator;
use Symfony\Component\HttpFoundation\Response;

class PageService{
    private $request;
    private $billService;
    private $twig;
    private $holidaysService;
    public function __construct(
        RequestStack $request,
        BillService $billService,
        \Twig_Environment $twig,
        FrenchHolidaysStringDateGenerator $holidaysService
    ){
        $this->request = $request;
        $this->billService = $billService;
        $this->twig = $twig;
        $this->holidaysService = $holidaysService;
    }
    public function renderView(String $nameOfView){
        if(is_callable(array($this, $nameOfView))){
            return $this->$nameOfView();
        }else{
            return $this->createNotFoundException('This view doesn\'t exist.' );
        }
    }
    private function step1(){
        $form = $this->billService->renderFormBill();
        return new Response( $this->twig->render('pages/step1.html.twig', [
            'form'      => $form->createView(),
            'holidays'  => $this->holidaysService->getHolidaysArrayString()
        ]));
    }
    private function step2(){
        $form = $this->billService->renderFormTickets();
        return new Response( $this->twig->render('pages/step2.html.twig', [
            'form'      => $form->createView(),
        ]));
    }
    private function step3(){
        
    }
    private function thankyou(){
        
    }

}