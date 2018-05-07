<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/user", name="api_user_")
 */
class UserController extends AbstractController
{
	/**
	 * @Route("/show", name="show_all", methods={"GET"})
	 * @param JsonService $jsonService
	 * @return JsonResponse
	 */
	public function showAll(JsonService $jsonService): JsonResponse
	{
		return $jsonService->successData(
			$this->getDoctrine()->getRepository(User::class)->findAll()
		);
	}
}