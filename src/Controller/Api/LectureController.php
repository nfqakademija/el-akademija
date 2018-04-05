<?php

namespace App\Controller\Api;

use App\Entity\Lecture;
use App\Form\LectureType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/lecture", name="api_lecture_")
 */
class LectureController extends BaseApiController
{
	/**
	 * LectureController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Lecture::class,
			LectureType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Lecture::class);
	}
}