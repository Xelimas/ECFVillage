<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actualite", name="actu")
     */
    public function index(): Response
    {
        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
        ]);
    }
}
