<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonService
{
	/**
	 * @param string $message
	 * @param array $params
	 * @return JsonResponse
	 */
	public function success(string $message = null, array $params = []): JsonResponse
	{
		if ($message) $params['message'] = $message;
		return new JsonResponse(array_merge(['success' => true], $params), Response::HTTP_OK);
	}

	/**
	 * @param array $data
	 * @param array $params
	 * @return JsonResponse
	 */
	public function successData(array $data, array $params = []): JsonResponse
	{
		return $this->success(null, array_merge($params, ['data' => $data]));
	}

	/**
	 * @param string $message
	 * @param array $params
	 * @param int $status
	 * @return JsonResponse
	 */
	public function error(string $message = null, array $params = [], int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
	{
		if ($message) $params['message'] = $message;
		return new JsonResponse(array_merge(['success' => false], $params), $status);
	}

	/**
	 * @param array $errors
	 * @return JsonResponse
	 */
	public function errors(array $errors): JsonResponse
	{
		return $this->error(null, ['errors' => $errors], Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @param string $class
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function objectNotFound(string $class): JsonResponse
	{
		return $this->error(
			(new \ReflectionClass($class))->getShortName() . ' not found',
			[],
			Response::HTTP_NOT_FOUND
		);
	}

	/**
	 * @param FormInterface $form
	 * @return JsonResponse
	 */
	public function formErrors(FormInterface $form): JsonResponse
	{
		$errors = [];
		foreach ($form->getErrors() as $error) {
			$errors[$form->getName()][] = $error->getMessage();
		}
		foreach ($form as $child) {
			foreach ($child->getErrors() as $error) {
				$errors[$child->getName()][] = $error->getMessage();
			}
		}
		return $this->error(null, ['errors' => $errors], Response::HTTP_BAD_REQUEST);
	}

	/**
	 * @param FormInterface $form
	 * @return JsonResponse
	 */
	public function parametersMissing(FormInterface $form): JsonResponse
	{
		$errors = [];
		foreach ($form->all() as $child) {
			$errors[$child->getName()] = ['Parameter is missing'];
		}
		return $this->error(null, ['errors' => $errors], Response::HTTP_BAD_REQUEST);
	}
}