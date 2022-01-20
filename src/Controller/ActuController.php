<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actualite", name="actu")
     */
    public function index(ActualiteRepository $repoActu): Response
    {
        $actues = $repoActu->findBy([], array('createdAt'=>'DESC'));

        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
            'actues' => $actues
        ]);
    }
}
