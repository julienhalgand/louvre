<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BillStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $arrayChoices = array(
            'form.billStep1.allJourney' => 'allJourney',
            'form.billStep1.halfJourney' => 'halfJourney'
        );
        $builder
            ->add('date_of_booking', TextType::class, array('attr' => array('placeholder' => 'dateOfBookingPlaceHolder')))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'example@example.example')))
            ->add('ticket_type', choiceType::class, array(
                'choices' => $arrayChoices 
            ))
            ->add('number_of_tickets', IntegerType::class, array('attr' => array('value' => 1)));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Bill::class,
        ));
    }
}