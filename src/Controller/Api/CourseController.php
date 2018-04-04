<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Form\CourseType;
use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/course", name="api_course_")
 */
class CourseController extends AbstractController
{
	/**
	 * @var JsonService $jsonService
	 */
	private $jsonService;

	/**
	 * CourseController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		$this->jsonService = $jsonService;
	}

	/**
	 * @Route("/new", name="new", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function new(Request $request): JsonResponse
	{
		$course = new Course();
		$form = $this->createForm(CourseType::class, $course, ['csrf_protection' => false]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing();
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$em = $this->getDoctrine()->getManager();
		$em->persist($course);
		$em->flush();
		return $this->jsonService->success();
	}

	/**
	 * @Route("/{id}/edit", name="edit", methods={"PATCH"})
	 * @param Request $request
	 * @param Course $course
	 * @return Response
	 */
	public function edit(Request $request, Course $course)
	{
		$form = $this->createForm(CourseType::class, $course, [
			'csrf_protection' => false,
			'method' => 'PATCH'
		]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing();
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$this->getDoctrine()->getManager()->flush();
		return $this->jsonService->success();
	}
}