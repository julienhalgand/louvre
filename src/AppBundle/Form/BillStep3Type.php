<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketStep3Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class BillStep3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('step1Bill', 'step2Bill', 'step3Bill'),
            'data_class' => Bill::class,
        ));
    }
}