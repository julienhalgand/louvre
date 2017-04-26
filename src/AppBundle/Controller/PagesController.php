<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\BillStep2Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Controller\ValidationController as v;
class PagesController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        return $this->render('pages/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/step1", name="step1")
     */
    public function step1Action(Request $request)
    {
        $bill = new Bill();
        $form = $this->createForm(BillStep1Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Si passé 14h on change le type de billet pour halfJourney
            $dateOfBooking = $bill->getDateOfBooking();
            $dateNow = new \DateTime();
            $dateNowHour = $dateNow->format('H');
            $dateNow->setTime(0,0,0);
            if($dateOfBooking == $dateNow && $dateNowHour >= 14 && $bill->getTicketType() == "allJourney"){
                $bill->setTicketType("halfJourney");
            }
            $request->getSession()->set('Bill', $bill);
            return $this->redirectToRoute('step2');                            
        }

        return $this->render('pages/step1.html.twig', [
            'form'      => $form->createView(),
            'holidays'  => "['".implode("', '",v::getHolidaysString())."']"
        ]);
    }
    /**
     * @Route("/step2", name="step2")
     */
    public function step2Action(Request $request)
    {
        //Test si objet ticket existe en session
        if(!$request->getSession()->get('Bill')){
            $request->getSession()->getFlashBag()->add(
                'warning',
                $this->get('translator')->trans('step1NotValid')
            );
            return $this->redirectToRoute('step1'); 
        }
        $bill = $request->getSession()->get('Bill');
        for($i=0; $i<$bill->getNumberOfTickets();$i++){
            if(count($bill->getTickets()) < $bill->getNumberOfTickets()){
                $bill->getTickets()->add(new Ticket());                
            }
        }
        $form = $this->createForm(BillStep2Type::class, $bill);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            foreach($bill->getTickets() as $ticket){
                $ticketPrice = $ticket->getTicketPrice($bill->getTicketType());
                $ticket->setPrice($ticketPrice);
            }            
            $request->getSession()->set('Bill', $bill);
            return $this->redirectToRoute('step3');                            
        }
        return $this->render('pages/step2.html.twig', [
            'form'      => $form->createView(),
        ]);
    }
    /**
     * @Route("/step3", name="step3")
     */
    public function step3Action(Request $request)
    {
        $bill = $request->getSession()->get('Bill');
        return $this->render('pages/step3.html.twig', [
            'Bill'  => $bill
        ]);
    }
    /**
     * @Route("/thankyou", name="thankyou")
     */
    public function thankyouAction(Request $request)
    {
        return $this->render('pages/thankyou.html.twig', [
        ]);
    }
            
}