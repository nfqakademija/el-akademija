<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/category", name="api_category_")
 */
class CategoryController extends BaseApiController
{
	/**
	 * CategoryController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Category::class,
			CategoryType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Category::class);
	}
}