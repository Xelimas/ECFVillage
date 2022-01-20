<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Evenement;
use App\Form\ActualiteType;
use App\Form\EvenementType;
use App\Repository\ActualiteRepository;
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
        $evenement = new Evenement();

        $formActu = $this->createForm(ActualiteType::class, $actualite);
        $formEvent = $this->createForm(EvenementType::class, $evenement);

        $formActu->handleRequest($request);
        $formEvent->handleRequest($request);

        if($formActu->isSubmitted() && $formActu->isValid()) {

            $actualite->setCreatedAt(new \DateTime());

            $manager->persist($actualite);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }
        if($formEvent->isSubmitted() && $formEvent->isValid()) {

            $evenement->setCreatedAt(new \DateTime());

            $manager->persist($evenement);
            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'formActu' => $formActu->createView(),
            'formEvent'=> $formEvent->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="admin_edit")
     */
    public function edit(Actualite $actualite,ActualiteRepository $repoActu, Request $request, EntityManagerInterface $manager)
    {
        $actu = $repoActu->findBy([], array(),$actualite->getId());
        $formActu = $this->createForm(ActualiteType::class, $actualite);
        $formActu->handleRequest($request);

        if($formActu->isSubmitted() && $formActu->isValid()) {


            $manager->persist($actualite);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/edit.html.twig', [
            'controller_name' => 'AdminController',
            'actues'=> $actu,
            'formActu' => $formActu->createView()
        ]);
    }
}
