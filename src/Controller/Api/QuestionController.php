<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
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

	/**
	 * @Route("/{id}/comments", name="comments")
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showComments(int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		return new JsonResponse(array_merge(
			$obj->jsonSerialize(),
			['comments' => $this->getDoctrine()->getRepository(Comment::class)->findByQuestion($obj)]
		));
	}
}