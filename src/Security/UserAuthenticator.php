<?php

namespace App\Security;

use App\Service\JsonService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class UserAuthenticator extends AbstractGuardAuthenticator
{
	/**
	 * @var JsonService $jsonService
	 * @var AuthorizationCheckerInterface $authorizationChecker
	 * @var UserPasswordEncoderInterface $encoder
	 */
	private $jsonService, $authorizationChecker, $encoder;

	/**
	 * UserAuthenticator constructor.
	 * @param JsonService $jsonService
	 * @param AuthorizationCheckerInterface $authorizationChecker
	 */
	public function __construct(JsonService $jsonService, AuthorizationCheckerInterface $authorizationChecker, UserPasswordEncoderInterface $encoder)
	{
		$this->jsonService = $jsonService;
		$this->authorizationChecker = $authorizationChecker;
		$this->encoder = $encoder;
	}

	public function supports(Request $request)
	{
		if ($request->getPathInfo() !== '/api/auth/login' || !$request->isMethod('POST'))
			return false;
		return true;
	}

	public function getCredentials(Request $request)
	{
		return [
			'email' => $request->get('email'),
			'password' => $request->get('password')
		];
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		return $userProvider->loadUserByUsername($credentials['email']);
	}

	public function checkCredentials($credentials, UserInterface $user)
	{
		if (!$this->encoder->isPasswordValid($user, $credentials['password']))
			throw new AuthenticationCredentialsNotFoundException('Invalid credentials');
		return true;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		return $this->jsonService->error($exception->getMessage(), [], Response::HTTP_FORBIDDEN);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		return null;
	}

	public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
	{
		return new RedirectResponse('/login');
	}

	public function supportsRememberMe()
	{
		return false;
	}
}
