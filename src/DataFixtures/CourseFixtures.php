<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$faker = Faker\Factory::create('lt_LT');
		$cities = ['Kaunas', 'Vilnius', 'Šiauliai'];
		$semesters = ['Pavasario semestras', 'Rudens semestras'];
		$currentYear = date('Y');
		for ($i = 1; $i >= 0; $i--) {
			$year = $currentYear - $i;
			$startDates = [$year . '-03-01', $year . '-09-01'];
			$endDates = [$year . '-06-01', $year . '-12-01'];

			for ($j = 0; $j < 2; $j++) {
				$startDate = $faker->dateTimeInInterval($startDates[$j], '+10 days');
				$endDate = $faker->dateTimeInInterval($endDates[$j], '+10 days');
				for ($z = 0, $len = count($cities); $z < $len; $z++) {
					$course = new Course();
					$course
						->setName($cities[$z] . ' | ' . $semesters[$j])
						->setStart($startDate)
						->setEnd($endDate);
					$manager->persist($course);
				}
			}
		}
		$manager->flush();
	}
}
