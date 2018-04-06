<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Service\JsonService;
use Doctrine\Common\Persistence\ObjectRepository;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
			return $this->jsonService->parametersMissing();
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
			return $this->jsonService->parametersMissing();
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
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function show($id): JsonResponse
    {
	    $obj = $this->getRepository()->find($id);

        if (!$obj)
            return $this->jsonService->objectNotFound($this->class);

        return new JsonResponse(
            array(
                "id" => $obj->getId(),
                "name" => $obj->getName(),
                "start" => $obj->getStart()->format('Y-m-d'),
                "end" => $obj->getEnd()->format('Y-m-d')
            )
        );
    }

    /**
     * @Route("/show", name="showAll", methods={"GET"})
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function showAll(): JsonResponse
    {
        $obj = $this->getRepository()->findAll();

        if (!$obj)
            return $this->jsonService->objectNotFound($this->class);

        $response = array();
        foreach($obj as $o) {
            $response[] = array(
                'id' => $o->getId(),
                'name' => $o->getName(),
                'start' => $o->getStart()->format('Y-m-d'),
                'end' => $o->getEnd()->format('Y-m-d')
            );
        }
        return new JsonResponse($response);
    }
}