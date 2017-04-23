<?php
namespace AppBundle\Form;

use AppBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TicketsStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', EmailType::class, array('attr' => array('placeholder' => 'firstnamePlaceHolder')))
            ->add('lastname', EmailType::class, array('attr' => array('placeholder' => 'lastnamePlaceHolder')))
            ->add('date_of_birth', TextType::class, array('attr' => array('placeholder' => 'dateOfBirthPlaceHolder')))
            ->add('ticket_type', choiceType::class, array(
                'choices' => array(
                    'Journée' => 'allJourney',
                    'Demi-journée' => 'halfJourney',
                )   
            ))
            ->add('number_of_tickets', IntegerType::class, array('attr' => array('value' => 1)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
        ));
    }
}