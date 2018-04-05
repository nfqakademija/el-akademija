<?php

namespace App\Security;

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
		return true;
	}

	public function getCredentials(Request $request)
	{
		return false;
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
	// todo
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
	// todo
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		return null;
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		return null;
	}

	public function start(Request $request, AuthenticationException $authException = null): JsonResponse
	{
		return $this->jsonService->error('Access Denied', [], Response::HTTP_FORBIDDEN);
	}

	public function supportsRememberMe()
	{
		return false;
	}
}
