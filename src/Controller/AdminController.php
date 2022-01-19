<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $actualite = new Actualite();

        $formActu = $this->createForm(ActualiteType::class, $actualite);

        $formActu->handleRequest($request);

        if($formActu->isSubmitted() && $formActu->isValid()) {

            $actualite->setCreatedAt(new \DateTime());

            $manager->persist($actualite);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'formActu' => $formActu->createView()
        ]);
    }
}
