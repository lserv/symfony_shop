<?php

namespace Shop\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Validation;
use Symfony\Component\Form\Extension\Core\Type as FormType;

/**
 * Class ContactType.
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', FormType\TextType::class, [
                'constraints' => [
                    new Validation\NotBlank(),
                    new Validation\Length(['max' => 50]),
                ]
            ])
            ->add('email', FormType\EmailType::class)
            ->add('subject', FormType\TextType::class, [
                'constraints' => [
                    new Validation\NotBlank(),
                    new Validation\Length(['max' => 50]),
                ]
            ])
            ->add('message', FormType\TextareaType::class, ['constraints' => [new Validation\NotBlank()]])
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }

}
