<?php

namespace App\Controller\Api;

use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseApiController extends AbstractController
{
	/**
	 * @var JsonService $jsonService
	 */
	protected $class, $type, $jsonService;

	/**
	 * BaseApiController constructor.
	 * @param string $class
	 * @param string $type
	 * @param JsonService $jsonService
	 */
	protected function __construct(string $class, string $type, JsonService $jsonService)
	{
		$this->class = $class;
		$this->type = $type;
		$this->jsonService = $jsonService;
	}

	abstract protected function getRepository(): ObjectRepository;

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	protected function new(Request $request): JsonResponse
	{
		$obj = new $this->class;
		$form = $this->createForm($this->type, $obj, ['csrf_protection' => false]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing();
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$em = $this->getDoctrine()->getManager();
		$em->persist($obj);
		$em->flush();
		return $this->jsonService->success();
	}

	/**
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	protected function edit(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			$this->jsonService->objectNotFound($this->class);

		$form = $this->createForm($this->type, $obj, [
			'csrf_protection' => false,
			'method' => 'PATCH'
		]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing();
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$this->getDoctrine()->getManager()->flush();
		return $this->jsonService->success();
	}

	/**
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	protected function delete(int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			$this->jsonService->objectNotFound($this->class);

		$em = $this->getDoctrine()->getManager();
		$em->remove($obj);
		$em->flush();
		return $this->jsonService->success();
	}
}