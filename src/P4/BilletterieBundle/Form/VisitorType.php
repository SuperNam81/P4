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
        ->add('lastname', TextType::class, array(
            'label' => 'form.nom',
            'translation_domain' => 'messages',
            'attr' => array('placeholder' => 'form.placeholder.nom'),
        ))
        ->add('firstname', TextType::class, array(
            'label' => 'form.prenom',
            'translation_domain' => 'messages',
            'attr' => array('placeholder' => 'form.placeholder.prenom'),
        ))
        ->add('dateBirth', BirthdayType::class, array(
            'label' => 'form.date.naissance',
            'translation_domain' => 'messages',
            'widget' => 'single_text',
            'placeholder' => array(
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            ),
        ))
        ->add('country', CountryType::class, array(
            'label' => 'form.pays',
            'translation_domain' => 'messages',
            'placeholder' => 'form.placeholder.pays',
        ))
        ->add('discount', CheckboxType::class, array(
            'label' => 'form.reduit',
            'translation_domain' => 'messages',
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
