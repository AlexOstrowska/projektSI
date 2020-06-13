<?php
/**
 * Answer type.
 */

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AnswerType.
 */
class AnswerType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array $options the options
     */
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder->add(
            'text',
            TextareaType::class,
            [
                'label' => 'label_answer',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Answer::class]);
    }

    /**
     *Returns the prefix of the template block name for this type.
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'answer';
    }
}