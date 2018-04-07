<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$categories = ['Frontend', 'Backend', 'Mysql', 'UX'];
		for ($i = 0, $len = count($categories); $i < $len; $i++) {
			$category = new Category();
			$category->setName($categories[$i]);
			$manager->persist($category);
		}
		$manager->flush();
	}
}
