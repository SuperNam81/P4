<?php

namespace P4\BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class VisitorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, array(
            'label' => 'Nom',
            'attr' => array('placeholder' => 'Entrez votre nom'),
        ))
        ->add('lastname', TextType::class, array(
            'label' => 'Prénom',
            'attr' => array('placeholder' => 'Entrez votre prénom'),
        ))
        ->add('dateBirth', BirthdayType::class, array(
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'placeholder' => array(
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ),
        ))
        ->add('country', CountryType::class, array(
            'label' => 'Pays',
            'placeholder' => 'Sélectionnez votre pays',
        ))
        ->add('discount', CheckboxType::class, array(
            'label' => 'Tarif réduit',     
            'required' => false));
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
