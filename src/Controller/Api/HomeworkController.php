<?php

namespace App\Controller\Api;

use App\Entity\Homework;
use App\Form\HomeworkType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/homework", name="api_homework_")
 */
class HomeworkController extends BaseApiController
{
	/**
	 * HomeworkController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Homework::class,
			HomeworkType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Homework::class);
	}
}