<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Entity\Etat;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("", name="liste-sorties", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nouvelle-sortie", methods={"GET", "POST"})
     */
    public function new(Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository, VilleRepository $villeRepository): Response
    {
        $villes= $villeRepository->findAll();
        $sortie = new Sortie();

        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $campus= $user->getCampus();

            if ($request->get('enregistrer')) {
                $etat=$etatRepository->find(1);
            }
           else {$sortie->setEtat($etatRepository->find(2));
            }

            $sortie->setOrganisateurs($user);

            $sortie->setSiteOrganisateur($campus);


//            // on attribut l'etat de la sortie selon "Enregistrer" ou "Pulbier"
//            $etat = $form->get('publier')->isClicked() ?
//                $etatRepository->find(2)
//                : $etatRepository->find(1);
//            $sortie->setEtat($etat)->setOrganisateur($user);

            $sortieRepository->add($sortie, true);

            return $this->redirectToRoute('details-sortie', ['id' => $sortie->getId()],  Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/new.html.twig', [
            'sortie' => $sortie,
            'villes'=> $villes,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/details/{id}", name="details-sortie", methods={"GET"})
     */
    public function show(Sortie $sortie): Response
    {
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
        ]);
    }

    /**
     * @Route("org/{id}/edit", name="editer-sortie", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // au clic sur le bouton "enregistrer
            if ($request->get('enregistrer')) {
                $sortie->setEtat($etatRepository->find(1));
            }
            if ($request->get('publier')) {
                $sortie->setEtat($etatRepository->find(2));
            }

//                $etat = $form->get('publier')->isClicked() ?
//                $etatRepository->find(2)
//                : $etatRepository->find(1);
//            $sortie->setEtat($etat);

            $sortieRepository->add($sortie, true);

            return $this->redirectToRoute('details-sortie', ['id' => $sortie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("org/{id}", name="effacer-sortie", methods={"GET", "POST"})
     */
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->request->get('_token'))) {
            $sortieRepository->remove($sortie, true);
        }

        return $this->redirectToRoute('liste-sorties', [], Response::HTTP_SEE_OTHER);
    }


}
