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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('visitors', CollectionType::class, array(
            'label' => false,
            'entry_type' => VisitorType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
        ))
        ->add('email', EmailType::class, array(
            'label' => 'form.email',
            'translation_domain' => 'messages',
            'attr' => array('placeholder' => 'form.placeholder.email'),
        ))
        ->add('ticket', ChoiceType::class, array(
            'label' => 'form.billet',
            'translation_domain' => 'messages',
            'choices' => array(
                'form.placeholder.journee' => true,
                'form.placeholder.demi.journee' => false,
            ),
        ))
        ->add('bookingDate', TextType::class, array(
            'label' => 'form.date.resa',
            'translation_domain' => 'messages',
            'attr' => array('width' => 50),
            'attr' => array('placeholder' => 'form.placeholder.date.resa'),
        ))        
        ->add('valider', SubmitType::class, array(
            'label' => 'form.valider',
            'translation_domain' => 'messages',
            'attr' => array('class' => 'btn-primary'),
        ));
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
