<?php

namespace App\Security;

use App\Entity\User;
use App\Service\JsonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class UserAuthenticator extends AbstractGuardAuthenticator
{
	/**
	 * @var JsonService $jsonService
	 */
	private $jsonService;

	/**
	 * UserAuthenticator constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		$this->jsonService = $jsonService;
	}

	public function supports(Request $request)
	{
		return $request->getPathInfo() === '/api/auth/login' && $request->isMethod('POST');
	}

	public function getCredentials(Request $request)
	{

	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		return new User();
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
		return true;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		return $this->jsonService->error($exception->getMessage(), [], Response::HTTP_FORBIDDEN);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		return $this->jsonService->success();
	}

	public function start(Request $request, AuthenticationException $authException = null): JsonResponse
	{
		return $this->jsonService->error('Access denied. Please log in.', [], Response::HTTP_FORBIDDEN);
	}

	public function supportsRememberMe()
	{
		return false;
	}
}
