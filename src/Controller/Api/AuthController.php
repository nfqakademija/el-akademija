<?php

namespace App\Controller\Api;

use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/api/auth", name="api_auth_")
 */
class AuthController extends AbstractController
{
	/**
	 * @var JsonService $jsonService
	 */
	private $jsonService;

	/**
	 * AuthController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		$this->jsonService = $jsonService;
	}

	/**
	 * @Route("/login", methods={"POST"})
	 * @return JsonResponse
	 */
	public function login(): JsonResponse
	{
		$user = $this->getUser();
		if ($user instanceof UserInterface)
			return $this->jsonService->success('Successfully logged in');
		return $this->jsonService->error();
	}

	/**
	 * @Route("/info", methods={"GET"})
	 * @param AuthorizationCheckerInterface $checker
	 * @return JsonResponse
	 */
	public function info(AuthorizationCheckerInterface $checker): JsonResponse
	{
		if ($checker->isGranted('IS_AUTHENTICATED_FULLY'))
			$data = [
				'loggedIn' => true,
				'roles' => $this->getUser()->getRoles()
			];
		else
			$data = ['loggedIn' => false];
		return $this->jsonService->successData($data);
	}

	/**
	 * @Route("/logout", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function logout(Request $request): JsonResponse
	{
		$request->getSession()->start();
		session_destroy();
		return $this->jsonService->success();
	}
}