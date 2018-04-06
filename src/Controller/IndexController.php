<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
	/**
	 * @Route("/Pagrindinis", name="Pagrindinis")
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
}