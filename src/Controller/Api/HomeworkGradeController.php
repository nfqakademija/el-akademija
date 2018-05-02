<?php

namespace App\Controller\Api;

use App\Entity\HomeworkGrade;
use App\Form\HomeworkGradeType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/homework_grade", name="api_homework_grade_")
 */
class HomeworkGradeController extends BaseApiController
{
	/**
	 * HomeworkGradeController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			HomeworkGrade::class,
			HomeworkGradeType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(HomeworkGrade::class);
	}
}