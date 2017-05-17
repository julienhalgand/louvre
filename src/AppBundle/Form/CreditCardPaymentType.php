<?php
namespace AppBundle\Form;

use AppBundle\Entity\CreditCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CreditCardPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentYear = intval(date("Y"));
        $yearsAvalable[$currentYear] =  $currentYear;
        $yearsAvalable[$currentYear+1] =  $currentYear+1;
        $yearsAvalable[$currentYear+2] =  $currentYear+2;
        $yearsAvalable[$currentYear+3] =  $currentYear+3;
        $yearsAvalable[$currentYear+4] =  $currentYear+4;
        $yearsAvalable[$currentYear+5] =  $currentYear+5;
        $yearsAvalable[$currentYear+6] =  $currentYear+6;
            
        $builder
            ->add('card_number', IntegerType::class, array('attr' => array(
                'placeholder' => 'stripe.placeholder.card_number',
                'data-stripe' => 'number'
            )))
            ->add('expiration_month', ChoiceType::class, array('attr' => array(
                'placeholder' => 'stripe.placeholder.expiration_date',
                'data-stripe' => 'exp-month'
            ),'choices' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10' => 10,
                '11' => 11,
                '12' => 12,
            )))
            ->add('expiration_year', ChoiceType::class, array('attr' => array(
                'placeholder' => 'stripe.placeholder.expiration_date',
                'data-stripe' => 'exp-year'
            ),'choices' => $yearsAvalable))
            ->add('security_code', TextType::class, array('attr' => array(
                'placeholder' => 'stripe.placeholder.security_code',
                'data-stripe' => 'cvc'
                )))
            ->add('stripe_token', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }
}