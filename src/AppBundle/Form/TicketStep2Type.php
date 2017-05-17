<?php
namespace AppBundle\Form;

use AppBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TicketStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('attr' => array('placeholder' => 'firstnamePlaceHolder')))
            ->add('lastname', TextType::class, array('attr' => array('placeholder' => 'lastnamePlaceHolder')))
            ->add('date_of_birth', TextType::class, array('attr' => array('placeholder' => 'dateOfBirthPlaceHolder')))
            ->add('country_code', CountryType::class, array('data' => 'FR'))
            ->add('reduced_price', CheckboxType::class, array(
                'label'        => 'Tarif réduit',
                'value'         => true,
                'required'     => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
            'error_mapping' => array(
                '.' => 'country_code',
            )
        ));
    }
}