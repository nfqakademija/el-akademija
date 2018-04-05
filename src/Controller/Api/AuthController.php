<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
		$user = new User();
		$form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing();
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);

		$user = $this->getUser();
		if ($user instanceof UserInterface)
			return $this->jsonService->success('Successfully logged in');
		return $this->jsonService->error();
	}
}