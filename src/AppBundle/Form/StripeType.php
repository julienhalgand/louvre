<?php
namespace AppBundle\Form;

use AppBundle\Entity\CreditCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TicketStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('card_number', TextType::class, array('attr' => array('placeholder' => 'stripe.placeholder.card_number')))
            ->add('expiration_date', DateType::class, array('attr' => array('placeholder' => 'stripe.placeholder.expiration_date')))
            ->add('security_code', TextType::class, array('attr' => array('placeholder' => 'stripe.placeholder.security_code'))
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CreditCard::class,
        ));
    }
}