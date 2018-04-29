<?php

namespace App\Form;

use App\Entity\HomeworkGrade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeworkGradeType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('homeworkLink')
			->add('user')
			->add('grade')
			->add('comment')
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => HomeworkGrade::class,
		]);
	}
}
