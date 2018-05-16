<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	/**
	 * @var UserPasswordEncoderInterface $encoder
	 */
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

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
				->setPassword($this->encoder->encodePassword($user, '123123'))
				->setRoles(['ROLE_STUDENT']);
			$manager->persist($user);
		}
		$manager->flush();
	}
}
