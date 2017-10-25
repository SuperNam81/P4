<?php

namespace P4\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use P4\BilletterieBundle\Repository\VisitorRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use P4\BilletterieBundle\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //->add('visitor', VisitorType::class)
        ->add('visitors', CollectionType::class, array(
            'label' => false,
            'entry_type' => VisitorType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
        ))
        ->add('email', EmailType::class, array(
            'label' => 'Adresse email'))
        ->add('ticket', ChoiceType::class, array(
            'label' => 'Type de billet',
            'choices' => array(
                'Journée' => true,
                'Demi-journée' => false,
            ),
          ))
        ->add('valider', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\BilletterieBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_billetteriebundle_booking';
    }
}
