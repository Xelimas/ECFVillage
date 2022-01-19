<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ActualiteRepository $repoActu, EvenementRepository $repoEvent): Response
    {
        $actues = $repoActu->findBy([], array('createdAt'=>'DESC'), 2);
        $events = $repoEvent->findBy([], array('createdAt'=>'DESC'), 2);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'actues'=> $actues,
            'events'=> $events
        ]);
    }

    /**
     * @Route("/histoire", name="histoire")
     */
    public function histoire(): Response
    {

        return $this->render('home/histoire.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
