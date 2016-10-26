<?php

namespace Shop\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Shop\CoreBundle\Entity\Category;

/**
 * Class ProductType.
 */
class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('category', EntityType::class, [
                'class' => 'CoreBundle:Category',
                'required' => true,
                'query_builder' => function ($em) {
                    return $em
                        ->createQueryBuilder('c')
                        ->orderBy('c.title', 'DESC');
                }
            ])
            ->add('user')           
            /*->add('cost', MoneyType::class, [
                'divisor' => 100,
                'currency'=> 'USD'
            ])*/
            ->add('image', HiddenType::class)
            ->add('cost', TextType::class)
            ->add('article', TextType::class)
            ->add('description', TextareaType::class)
            ->add('metaTitle', TextType::class)
            ->add('metaKeywords', TextareaType::class)
            ->add('metaDescription', TextareaType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\CoreBundle\Entity\Product',
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'product';
    }
}
