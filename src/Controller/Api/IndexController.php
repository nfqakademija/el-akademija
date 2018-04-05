<?php

namespace App\Controller\Api;

use App\Entity\Course;
use App\Form\CourseType;
use App\Service\JsonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class IndexController extends AbstractController
{
	/**
	 * @var JsonService $json
	 */
	public $json;

	public function __construct(JsonService $json)
	{
		$this->json = $json;
	}

	/**
	 * @Route("/get_example", name="get_example")
	 */
	public function getExample()
	{
		$course = new Course();
		$form = $this->createForm(CourseType::class, $course, ['csrf_protection' => false]);
		return $this->render('index.html.twig', ['form' => $form->createView()]);
	}
}