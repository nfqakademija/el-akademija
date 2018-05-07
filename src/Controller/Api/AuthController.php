<?php

namespace App\Controller\Api;

use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
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
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function login(Request $request): JsonResponse
	{
//		$user = new User();
//		$form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
//		$form->handleRequest($request);
//
//		if (!$form->isSubmitted())
//			return $this->jsonService->parametersMissing($form);
//		if (!$form->isValid())
//			return $this->jsonService->formErrors($form);

		$user = $this->getUser();
		var_dump($user);
		if ($user instanceof UserInterface)
			return $this->jsonService->success('Successfully logged in2');
		return $this->jsonService->error();
	}

	/**
	 * @Route("/logout", methods={"GET"})
	 * @param Session $session
	 * @return JsonResponse
	 */
	public function logout(Session $session): JsonResponse
	{
		$session->invalidate();
		return $this->jsonService->success();
	}
}