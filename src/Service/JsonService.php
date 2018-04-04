<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonService
{
	/**
	 * @param array $params
	 * @return JsonResponse
	 */
	public function success(array $params = []): JsonResponse
	{
		return new JsonResponse(array_merge(['success' => true], $params));
	}

	/**
	 * @param array $params
	 * @return JsonResponse
	 */
	public function error(array $params = []): JsonResponse
	{
		return new JsonResponse(array_merge(['success' => false], $params));
	}

	/**
	 * @param string $class
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function objectNotFound(string $class): JsonResponse
	{
		return $this->error([
			'message' => (new \ReflectionClass($class))->getShortName() . ' object not found'
		]);
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
		return $this->error(['errors' => $errors]);
	}

	/**
	 * @return JsonResponse
	 */
	public function parametersMissing(): JsonResponse
	{
		return $this->error(['message' => 'All parameters are missing']);
	}
}