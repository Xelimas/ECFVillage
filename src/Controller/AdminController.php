<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Evenement;
use App\Form\ActualiteType;
use App\Form\EvenementType;
use App\Repository\ActualiteRepository;
use App\Repository\EvenementRepository;
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
     * @Route("/admin/{id}/editActu", name="admin_edit_actu")
     */
    public function editActu(Actualite $actualite,ActualiteRepository $repoActu, Request $request, EntityManagerInterface $manager)
    {

        $actu = $repoActu->findBy([], array(),$actualite->getId());
        
        $formActu = $this->createForm(ActualiteType::class, $actualite);
        
        $formActu->handleRequest($request);
       

        if($formActu->isSubmitted() && $formActu->isValid()) {

            $manager->persist($actualite);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        

        return $this->render('admin/editActu.html.twig', [
            'controller_name' => 'AdminController',
            'actues'=> $actu,            
            'formActu' => $formActu->createView()
            
        ]);
    }

    /**
     * @Route("/admin/{id}/editEvent", name="admin_edit_event")
     */
    public function edit(Evenement $evenement,EvenementRepository $repoEvent, Request $request, EntityManagerInterface $manager)
    {
        
        $event = $repoEvent->findBy([], array(), $evenement->getId());
        
        $formEvent = $this->createForm(EvenementType::class, $evenement);
        
        $formEvent->handleRequest($request);

        

        if($formEvent->isSubmitted() && $formEvent->isValid()) {

            $manager->persist($evenement);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/editEvent.html.twig', [
            'controller_name' => 'AdminController',
            'events'=> $event,
            'formEvent'=> $formEvent->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}/supprimerActu", name="supprimer_actu")
     */
    public function supprimerActu(Actualite $actualite,ActualiteRepository $repoActu,EntityManagerInterface $manager): Response
    {
        $actues = $repoActu->findBy([], array(),$actualite->getId());

        $manager->remove($actualite);
        $manager->flush();

        return $this->redirectToRoute('actu');


        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
            'actues' => $actues
        ]);
    }

    /**
     * @Route("/admin/{id}/supprimerEvent", name="supprimer_event")
     */
    public function supprimerEvent(Evenement $evenement,EvenementRepository $repoEvent, EntityManagerInterface $manager): Response
    {
        $events = $repoEvent->findBy([], array(),$evenement->getId());

        $manager->remove($evenement);
        $manager->flush();

        return $this->redirectToRoute('event');


        return $this->render('actu/index.html.twig', [
            'controller_name' => 'ActuController',
            'events' => $events
        ]);
    }
}
