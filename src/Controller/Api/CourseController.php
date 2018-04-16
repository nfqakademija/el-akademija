<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Entity\Homework;
use App\Entity\Lecture;
use App\Form\CourseType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course", name="api_course_")
 */
class CourseController extends BaseApiController
{
	/**
	 * CourseController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Course::class,
			CourseType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Course::class);
	}

	/**
	 * @Route("/{id}/lectures", name="lectures")
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showLectures(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$args = $this->handleOPS($request, Lecture::class);
		return $this->jsonService->successData(
			$this
				->getDoctrine()
				->getRepository(Lecture::class)
				->findByCourse($obj, ...$args->getArray()),
			$args->getMetaInfo()
		);
	}

	/**
	 * @Route("/{id}/homework", name="homework")
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showHomework(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$args = $this->handleOPS($request, Homework::class);
		return $this->jsonService->successData(
			$this
				->getDoctrine()
				->getRepository(Homework::class)
				->findByCourse($obj, $args),
			$args->getMetaInfo()
		);
	}
}