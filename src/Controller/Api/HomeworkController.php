<?php

namespace App\Controller\Api;

use App\Entity\Homework;
use App\Entity\HomeworkLink;
use App\Form\HomeworkType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

	/**
	 * @Route("/{id}/homework_links", name="homework_links", requirements={"id"="\d+"})
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showHomeworkLinks(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$args = $this->handleOPS($request, HomeworkLink::class);
		return $this->jsonService->successData(
			$this
				->getDoctrine()
				->getRepository(HomeworkLink::class)
				->findByHomework($obj, $args),
			$args->getMetaInfo()
		);
	}
}