<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/comment", name="api_comment_")
 */
class CommentController extends BaseApiController
{
	/**
	 * CommentController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Comment::class,
			CommentType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Comment::class);
	}
}