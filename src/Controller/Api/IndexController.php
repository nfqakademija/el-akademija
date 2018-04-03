<?php

namespace App\Controller\Api;

use App\Service\JsonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class IndexController
{
	/**
	 * @var JsonService $json
	 */
	public $json;

	public function __construct(JsonService $json)
	{
		$this->json = $json;
	}

	/**
	 * @Route("/get_example", name="get_example")
	 */
	public function getExample(): JsonResponse
	{
		return $this->json->success([
			'test' => false
		]);
	}
}