<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bill;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/step1", name="step1")
     */
    public function step1Action(Request $request)
    {
        $bill = new Bill();
        $form = $this->createFormBuilder($bill)
            ->add('date_of_booking', TextType::class, array('attr' => array('placeholder' => 'dateOfBookingPlaceHolder')))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'example@example.example')))
            ->add('ticket_type', choiceType::class, array(
                'choices' => array(
                    'Journée' => 'allJourney',
                    'Demi-journée' => 'halfJourney',
                )   
            ))
            ->add('number_of_tickets', IntegerType::class, array('attr' => array('value' => 1)))
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $bill = $form->getData();
                    die(dump($bill));
                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($task);
                // $em->flush();

                return $this->redirectToRoute('task_success');
            }
            return $this->render('default/step1.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
                'form' => $form->createView()
            ]);
    }

}
