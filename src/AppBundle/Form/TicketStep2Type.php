<?php
namespace AppBundle\Form;

use AppBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class TicketStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('attr' => array('placeholder' => 'step2.firstnamePlaceHolder')))
            ->add('lastname', TextType::class, array('attr' => array('placeholder' => 'step2.lastnamePlaceHolder')))
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
                $ticket = $event->getData();
                $dateOfBookingInputValue = '';
                if ($ticket->getDateOfBirth() != null){
                    $dateOfBookingInputValue = $ticket->getDateOfBirth()->format('d/m/Y');
                }
                $form = $event->getForm();
                $form->add('date_of_birth', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'placeholder' => 'step2.dateOfBirthPlaceHolder',
                        'value' => $dateOfBookingInputValue)
                ));
            })
            ->add('country_code', CountryType::class, array('data' => 'FR'))
            ->add('reduced_price', CheckboxType::class, array(
                'label'        => 'step2.reducedPrice',
                'value'         => true,
                'required'     => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('step2Ticket'),
            'data_class' => Ticket::class,
            'error_mapping' => array(
                '.' => 'country_code',
            )
        ));
    }
}