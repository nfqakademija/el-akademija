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
		foreach ($categories as $cat) {
			$category = new Category();
			$category->setName($cat);
			$manager->persist($category);
		}
		$manager->flush();
	}
}
