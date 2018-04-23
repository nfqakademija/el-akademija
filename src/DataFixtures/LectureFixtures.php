<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Lecture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class LectureFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
//		$courses = $manager->getRepository(Course::class)->findAll();
//		$categories = $manager->getRepository(Category::class)->findAll();
//		$cats = [];
//		foreach ($categories as $category) {
//			$cats[$category->getName()] = $category;
//		}
//		$lectures = [
//			[
//				'category' => $cats['Frontend'],
//				'name' => 'PHP / Intro',
//				'description' => 'none',
//				'start' => '03-13 17:00'
//			]
//		];
//		foreach ($courses as $course) {
//			$courseDate = $course->getStart();
//			$courseYear = $courseDate->format('Y');
//			foreach ($lectures as $item) {
//				$lecture = new Lecture();
//				$lecture
//					->setCourse($course)
//					->setName($item['name'])
//					->setDescription($item['description']);
//				$lectureDate = new \DateTime($courseYear . '-' . $item['start']);
//				if ($lectureDate < $courseDate)
//					$lectureDate = new \DateTime(($courseYear + 1) . '-' . $item['start']);
//				$lectureEnd = clone $lectureDate;
//				$lectureEnd->modify('+2 hours');
//
//				$lecture
//					->setStart($lectureDate)
//					->setEnd($lectureEnd);
//				$manager->persist($lecture);
//			}
//		}
//		$manager->flush();
	}
}
