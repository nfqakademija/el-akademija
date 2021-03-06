<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$faker = Faker\Factory::create('lt_LT');
		$categories = $manager->getRepository(Category::class)->findAll();
		$users = $manager->getRepository(User::class)->findAll();
		$lastDate = $faker->dateTimeInInterval('-35 days', '+10 days');
		for ($i = 0; $i < 10; $i++) {
			$question = new Question();
			$question
				->setCategory($faker->randomElement($categories))
				->setUser($faker->randomElement($users))
				->setTitle($faker->realText(20))
				->setText($faker->realText(200))
				->setCreated($lastDate);
			$manager->persist($question);
			$lastDate = $faker->dateTimeInInterval($lastDate, '+2 days');
		}
		$manager->flush();
	}

	public function getDependencies()
	{
		return [UserFixtures::class];
	}
}
