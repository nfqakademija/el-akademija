<?php

namespace App\Controller\Api;

use App\Entity\HomeworkLink;
use App\Form\HomeworkLinkType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/homework_link", name="api_homework_link_")
 */
class HomeworkLinkController extends BaseApiController
{
	/**
	 * HomeworkLinkControllerController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			HomeworkLink::class,
			HomeworkLinkType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(HomeworkLink::class);
	}
}