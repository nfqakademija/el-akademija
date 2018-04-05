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
		if (!$form->isSubmitted())
			return $this->parametersMissing();
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
	 * @return JsonResponse
	 */
	public function parametersMissing(): JsonResponse
	{
		return $this->error('All parameters are missing', [], Response::HTTP_BAD_REQUEST);
	}
}