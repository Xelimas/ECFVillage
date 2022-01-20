<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/evenement", name="event")
     */
    public function index(EvenementRepository $repoEvent): Response
    {
        $events = $repoEvent->findBy([], array('createdAt'=>'DESC'));
       
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events
        ]);
    }
}
