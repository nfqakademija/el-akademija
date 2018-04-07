<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$faker = Faker\Factory::create('lt_LT');
		$questions = $manager->getRepository(Question::class)->findAll();
		$users = $manager->getRepository(User::class)->findAll();
		$now = new \DateTime();
		$dates = [];
		for ($i = 0; $i < 50; $i++) {
			$comment = new Comment();
			$question = $faker->randomElement($questions);
			$id = $question->getId();
			if (array_key_exists($id, $dates)) {
				$lastDate = end($dates[$id]);
			} else {
				$lastDate = $question->getCreated()->format('Y-m-d H:i:s');
				$dates[$id] = [];
			}
			$lastDate = $faker->dateTimeInInterval($lastDate, '+2 days');
			$dates[$id][] = $lastDate;
			if ($lastDate > $now) {
				$i--;
				continue;
			}

			$comment
				->setQuestion($question)
				->setUser($faker->randomElement($users))
				->setText($faker->realText(300))
				->setCreated($lastDate);
			$manager->persist($comment);
		}
		$manager->flush();
	}

	public function getDependencies()
	{
		return [QuestionFixtures::class];
	}
}
