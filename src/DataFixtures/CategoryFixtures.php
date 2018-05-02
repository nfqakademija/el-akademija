<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$categories = [
			'Frontend' => '#008000',
			'Backend' => '#0000ff',
			'Mysql' => '#ff0000',
			'UX' => '#ffc107'
		];
		foreach ($categories as $cat => $color) {
			$category = new Category();
			$category->setName($cat);
			$category->setColor($color);
			$manager->persist($category);
		}
		$manager->flush();
	}
}
