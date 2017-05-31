<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BillStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
           /* ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
                $bill = $event->getData();
                $dateOfBookingInputValue = '';
                if ($bill->getDateOfBooking() != null){
                    $dateOfBookingInputValue = $bill->getDateOfBooking();
                }
                $form = $event->getForm();*/
                ->add('date_of_booking', TextType::class, array('attr' => array('placeholder' => 'dateOfBookingPlaceHolder'/*, 'value' => $dateOfBookingInputValue*/)))
           /* })*/
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'example@example.example')))
            ->add('ticket_type', ChoiceType::class, array(
                'choices' => Bill::TYPE_TICKET_TYPE_ARRAY
            ))
            ->add('number_of_tickets', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('step1Bill'),
            'data_class' => Bill::class,
        ));
    }
}