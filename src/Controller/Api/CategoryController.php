<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\CategoryType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category", name="api_category_")
 */
class CategoryController extends BaseApiController
{
	/**
	 * CategoryController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Category::class,
			CategoryType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Category::class);
	}

	/**
	 * @Route("/{id}/questions", name="questions")
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showQuestions(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		return $this->jsonService->successData(
			$this
				->getDoctrine()
				->getRepository(Question::class)
				->findByCategory($obj, ...$this->handleOPS($request, Question::class)->getArray())
		);
	}
}