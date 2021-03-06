<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

/**
 * @Route("/api/question", name="api_question_")
 */
class QuestionController extends BaseApiController
{
	/**
	 * LectureController constructor.
	 * @param JsonService $jsonService
	 */
	public function __construct(JsonService $jsonService)
	{
		parent::__construct(
			Question::class,
			QuestionType::class,
			$jsonService
		);
	}

	protected function getRepository(): ObjectRepository
	{
		return $this->getDoctrine()->getRepository(Question::class);
	}

	/**
	 * @Route("/new", name="new", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function new(Request $request): JsonResponse
	{
		$obj = new Question();
		$form = $this->createForm(QuestionType::class, $obj, ['csrf_protection' => false]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing($form);
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$em = $this->getDoctrine()->getManager();
		$em->persist($obj);
		$em->flush();
		return $this->jsonService->successData([
			'question' => $obj->getId()
		]);
	}

	/**
	 * @Route("/show", name="show_all", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function showAll(Request $request): JsonResponse
	{
		$args = $this->handleOPS($request);
		$args->setOrderBy('created');
		$args->setOrder('desc');
		return $this->jsonService->successData(
			$this->getRepository()->findBy([], ...$args->getArray()),
			$args->getMetaInfo()
		);
	}

	/**
	 * @Route("/{id}/comments", name="comments", requirements={"id"="\d+"})
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function showComments(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$args = $this->handleOPS($request, Comment::class);
		return $this->jsonService->successData(
			array_merge(
				$obj->jsonSerialize(),
				[
					'comments' =>
						$this
							->getDoctrine()
							->getRepository(Comment::class)
							->findByQuestion($obj, ...$args->getArray())
				]
			),
			$args->getMetaInfo()
		);
	}

	/**
	 * @Route("/search", name="search")
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function search(Request $request): JsonResponse
	{
		$param = $request->query->get('param');
		$validator = Validation::createValidator();
		$violations = $validator->validate($param, [
			new NotBlank(),
			new Length([
				'min' => 3,
				'max' => 50
			])
		]);
		if (count($violations) !== 0)
			return $this->jsonService->errors([
				'param' => [$violations->get(0)->getMessage()]
			]);

		$args = $this->handleOPS($request, Question::class);
		$rows = $this->getRepository()->searchCount($param);
		$args->setTotalPages(ceil($rows / $args->getLimit()));
		return $this->jsonService->successData(
			$this
				->getRepository()
				->search($param, $args),
			$args->getMetaInfo()
		);
	}
}