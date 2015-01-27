<?php

namespace oc\samirBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',     'text')
            ->add('email',     'text')
            ->add('author',     'text')
            ->add('content',     'textarea')
            ->add('published',     'checkbox')
            ->add('created',     'datetime')
            ->add('image',      new ImageType())
            ->add('category',      new CategoryType())
            ->add('save',     'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'oc\samirBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oc_samirbundle_advert';
    }
}
