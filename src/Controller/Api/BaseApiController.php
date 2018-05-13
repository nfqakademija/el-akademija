<?php

namespace App\Controller\Api;

use App\Model\QueryArgs;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

abstract class BaseApiController extends AbstractController
{
	/**
	 * @var string $class
	 * @var string $type
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
	 * @Route("/new", name="new", methods={"POST"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function new(Request $request): JsonResponse
	{
		$obj = new $this->class;
		$form = $this->createForm($this->type, $obj, ['csrf_protection' => false]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing($form);
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$em = $this->getDoctrine()->getManager();
		$em->persist($obj);
		$em->flush();
		return $this->jsonService->success();
	}

	/**
	 * @Route("/{id}/edit", name="edit", methods={"PATCH"})
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function edit(Request $request, int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$form = $this->createForm($this->type, $obj, [
			'csrf_protection' => false,
			'method' => 'PATCH'
		]);
		$form->handleRequest($request);

		if (!$form->isSubmitted())
			return $this->jsonService->parametersMissing($form);
		if (!$form->isValid())
			return $this->jsonService->formErrors($form);
		$this->getDoctrine()->getManager()->flush();
		return $this->jsonService->success();
	}

	/**
	 * @Route("/{id}/delete", name="delete", methods={"GET"})
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function delete(int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		$em = $this->getDoctrine()->getManager();
		$em->remove($obj);
		$em->flush();
		return $this->jsonService->success();
	}

	/**
	 * @Route("/{id}/show", name="show", methods={"GET"})
	 * @param int $id
	 * @return JsonResponse
	 * @throws \ReflectionException
	 */
	public function show(int $id): JsonResponse
	{
		$obj = $this->getRepository()->find($id);
		if (!$obj)
			return $this->jsonService->objectNotFound($this->class);

		return $this->jsonService->successData($obj->jsonSerialize());
	}

	/**
	 * @Route("/show", name="show_all", methods={"GET"})
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function showAll(Request $request): JsonResponse
	{
		$args = $this->handleOPS($request);
		return $this->jsonService->successData(
			$this->getRepository()->findBy([], ...$args->getArray()),
			$args->getMetaInfo()
		);
	}

	/**
	 * @param Request $request
	 * @param string|null $class
	 * @return QueryArgs
	 */
	protected function handleOPS(Request $request, string $class = null): QueryArgs
	{
		if (!$class)
			$class = $this->class;

		$args = new QueryArgs();
		try {
			$whiteList = call_user_func($class . '::whiteListedFields');
			$limit = call_user_func($class . '::getLimit');
		} catch (\Exception $err) {
			return $args;
		}

		$orderBy = strtolower($request->query->get('orderBy', ''));
		$order = strtolower($request->query->get('order', ''));
		if (in_array($orderBy, $whiteList))
			$args->setOrderBy($orderBy);
		if (in_array($order, ['asc', 'desc']))
			$args->setOrder(strtoupper($order));
		$page = (int) $request->query->get('page');
		if ($page <= 0)
			$page = 1;
		$offset = ($page - 1) * $limit;
		$rowsCount = $this->getRepository()
			->createQueryBuilder('u')
			->select('count(u.id)')
			->getQuery()
			->getSingleScalarResult();
		return $args
			->setLimit($limit)
			->setOffset($offset)
			->setPage($page)
			->setTotalPages(ceil($rowsCount / $limit));
	}
}