<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonService
{
	public function success(array $params = []): JsonResponse
	{
		return new JsonResponse(array_merge(['success' => true], $params));
	}

	public function error(array $params = []): JsonResponse
	{
		return new JsonResponse(array_merge(['success' => false], $params));
	}

	public function formErrors(Form $form): JsonResponse
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

	public function parametersMissing(): JsonResponse
	{
		return $this->error(['message' => 'All parameters are missing']);
	}
}