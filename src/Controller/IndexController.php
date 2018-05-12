<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
	/**
	 * @Route("/", name="index")
	 * @return Response
	 */
	public function index(): Response
	{
		return $this->render('index.html.twig');
	}

    /**
     * @Route("/questions", name="questions")
     * @return Response
     */
    public function questions(): Response
    {
        return $this->render('questions.html.twig');
    }
    /**
     * @Route("/question/{id}", name="question")
     * @return Response
     */
    public function question($id): Response
    {
        return $this->render('question.html.twig', ['id' => $id]);
    }

    /**
     * @Route("/schedule", name="schedule")
     * @return Response
     */
    public function schedule(): Response
    {
        return $this->render('schedule.html.twig');
    }

    /**
     * @Route("/admin/schedule", name="admin_schedule")
     * @return Response
     */
    public function admin_schedule(): Response {
        return $this->render('admin/admin_schedule.html.twig');
    }
}