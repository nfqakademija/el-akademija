<?php

namespace App\Security;

use App\Service\JsonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
	/**
	 * @var JsonService $jsonService
	 */
	private $jsonService;

	/**
	 * AccessDeniedHandler constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		$this->jsonService = $jsonService;
	}

	/**
	 * @param Request $request
	 * @param AccessDeniedException $accessDeniedException
	 * @return JsonResponse
	 */
	public function handle(Request $request, AccessDeniedException $accessDeniedException): JsonResponse
	{
		return $this->jsonService->error('Access denied', [], Response::HTTP_FORBIDDEN);
	}
}