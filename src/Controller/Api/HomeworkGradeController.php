<?php

namespace App\Controller\Api;

use App\Entity\HomeworkGrade;
use App\Entity\HomeworkGrades;
use App\Form\HomeworkGradesType;
use App\Form\HomeworkGradeType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

	/**
	 * @Route("/new", name="new", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function new(Request $request): JsonResponse
	{
		$objs = new HomeworkGrades();
		$form = $this->createForm(HomeworkGradesType::class, $objs, ['csrf_protection' => false]);
		$form->handleRequest($request);
		var_dump($request->request);
		var_dump($objs->getGrades());

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing($form);
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$em = $this->getDoctrine()->getManager();
		$em->persist($objs);
		$em->flush();
		return $this->jsonService->success();
	}
}