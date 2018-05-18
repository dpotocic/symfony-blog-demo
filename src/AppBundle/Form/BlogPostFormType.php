<?php
namespace AppBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class BlogPostFormType extends \Symfony\Component\Form\AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                    'label' => 'Blog title',
                ])
            ->add('text',  CKEditorType::class, [
                    'label' => 'Blog text',
                ])
            ->add('slug', TextType::class, [
                    'label' => 'Post URL (slug)',
                ])
            ->add('publishDate', DateTimeType::class, [
                    'label' => 'Publish Date',
                ])
            ->add('visible', ChoiceType::class, [
                    'choices' => array('Disabled' => 0, 'Visible' => 1),
                    'label' => 'Disabled',
                ])
            ->add('tags',  TextType::class, [
                    'label' => 'Blog tag (separate by space)',
                ])
            ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-success']
                ])
            ->add('cancel', ButtonType::class, [
                    'label' => 'Cancel',
                    'attr' => ['class' => 'btn']
                ]);
    }
}