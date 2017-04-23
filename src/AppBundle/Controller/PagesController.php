<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Form\BillStep1Type;
use AppBundle\Form\TicketsStep2Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
            if($bill->getDateOfBooking()->format('d') > 14){
                //Test si pas demi-journée
                if($bill->getTicketType() == "allJourney"){
                    $bill->setTicketType("halfJourney");
                }
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
        $ticket = new Ticket();
        $form = $this->createForm(TicketsStep2Type::class, $ticket);
        $form->handleRequest($request);
        //Test si objet ticket existe en session
        return $this->render('pages/step2.html.twig', [
        ]);
    }
    /**
     * @Route("/step3", name="step3")
     */
    public function step3Action(Request $request)
    {
        return $this->render('pages/step3.html.twig', [
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