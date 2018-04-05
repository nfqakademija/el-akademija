<?php

namespace App\Controller\Api;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/question", name="api_question_")
 */
class QuestionController extends BaseApiController
{
	/**
	 * LectureController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Question::class,
			QuestionType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Question::class);
	}
}