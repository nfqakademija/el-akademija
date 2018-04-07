<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$faker = Faker\Factory::create('lt_LT');
		for ($i = 0; $i < 20; $i++) {
			$user = new User();
			$name = explode(' ', $faker->name);
			$user
				->setFirstname($name[0])
				->setLastname($name[1])
				->setEmail($faker->email)
				->setPassword($faker->password(6, 20));
			$manager->persist($user);
		}
		$manager->flush();
	}
}
