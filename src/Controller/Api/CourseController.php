<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Form\CourseType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
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
}