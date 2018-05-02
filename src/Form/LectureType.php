<?php

namespace App\Form;

use App\Entity\Lecture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LectureType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('course')
			->add('lector')
			->add('category')
			->add('name')
			->add('description')
			->add('start', DateTimeType::class, ['widget' => 'single_text'])
			->add('end', DateTimeType::class, ['widget' => 'single_text'])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Lecture::class,
		]);
	}
}
