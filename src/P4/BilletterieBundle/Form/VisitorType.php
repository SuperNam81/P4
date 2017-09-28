<?php

namespace P4\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class VisitorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',    TextType::class)
        ->add('lastname',    TextType::class)
        ->add('dateBirth',    BirthdayType::class)
        ->add('country',    CountryType::class)
        ->add('discount',    CheckboxType::class, array('required' => false))

        ->add('ticket',    ChoiceType::class, array(
        'choices' => array(
            'Journée' => true,
            'Demi-journée' => false,
        ),
      ))

        ->add('quantity',    ChoiceType::class, array(
        'choices'  => array(
            'Nombre de billet' => range(1,10),
        ),
      ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\BilletterieBundle\Entity\Visitor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'p4_billetteriebundle_visitor';
    }


}
