<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\DateTime;

class BillStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
                $bill = $event->getData();
                $dateOfBookingInputValue = '';
                if ($bill->getDateOfBooking() != null){
                    $dateOfBookingInputValue = $bill->getDateOfBooking()->format('d/m/Y');
                }
                $form = $event->getForm();
                $form->add('date_of_booking', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'placeholder' => 'dateOfBookingPlaceHolder',

                        'value' => $dateOfBookingInputValue)
                    ));
            })
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