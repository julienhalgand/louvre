<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bill;
use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketStep2Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BillStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tickets', CollectionType::class, array(
                'entry_type'     => TicketStep2Type::class
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('step2Bill'),
            'data_class' => Bill::class,
        ));
    }
}