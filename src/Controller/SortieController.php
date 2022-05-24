<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\AnnulationType;
use App\Form\FiltreSortieType;
use App\Form\FiltresType;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
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
     * @Route("", name="liste-sorties", methods={"GET", "POST"})
     */
    public function index(Request $request, SortieRepository $sortieRepository): Response
    {
        $user = $this->getUser();
        $filtreForm = $this->createForm(FiltresType::class);
        $filtreForm->handleRequest($request);

        if ($filtreForm->isSubmitted() && $filtreForm->isValid()) {
            $filtre = $filtreForm->getData();
            if(!empty(array_filter($filtre, function ($f){ return $f;}))){
                $sorties = $sortieRepository->sortieParFiltres($filtre);
            } else {
                $sorties= $sortieRepository->findAll();
            }
        }else {
            $sorties = $sortieRepository->findAll();
        }
        return $this->renderForm('sortie/index.html.twig', [
            'sorties' => $sorties,
            'user'=> $user,
            'sortiesFiltreesForm'=> $filtreForm
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
                $sortie->setEtat($etatRepository->find(1));
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

            $this->addFlash('success', 'La sortie a été créée !');
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
    public function show(Sortie $sortie, VilleRepository $villeRepository): Response
    {
        $villes= $villeRepository->findAll();
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,
            'villes'=> $villes,
        ]);
    }

    /**
     * @Route("org/{id}/edit", name="editer-sortie", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository, EtatRepository $etatRepository, VilleRepository $villeRepository): Response
    {
        $villes= $villeRepository->findAll();
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
            $this->addFlash('success', 'La sortie a été modifiée !');

            return $this->redirectToRoute('details-sortie', ['id' => $sortie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'villes'=> $villes,
            'form' => $form,
        ]);
    }
    /**
     * @Route("org/{id}", name="annuler-sortie", methods={"GET", "POST"})
     */
    public function annuler(Request $request, Sortie $sortie, SortieRepository $sortieRepository, EtatRepository $etatRepository): Response
    {
        $form = $this->createForm(AnnulationType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // au clic sur le bouton "annuler"
            if ($request->get('annuler')) {
                $sortie->setEtat($etatRepository->find(6));
            }
            $sortieRepository->add($sortie, true);
            //message flash
            $this->addFlash('success', 'La sortie a été annulée !');

            return $this->redirectToRoute('liste-sorties', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('sortie/annulerSortie.html.twig', [
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

    /**
     * @Route("/{action}/{id}/", name="inscription_desinscription", methods={"GET", "POST"})
     */

    public function inscription(int $id, string $action, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
    {
        $sortie = $sortieRepository->find($id);
        $user = $this->getUser();
        $flashMesssage = '';
        switch ($action) {
            case 'inscription':
                $sortie->addParticipant($user);
                $flashMesssage = 'Vous êtes inscrit(e)'. $sortie->getNom();
                break;
            case 'desinscription':
                $sortie->removeParticipant($user);
                $flashMesssage = 'Vous êtes désinscrit(e)'. $sortie->getNom();
                break;
        }
        $entityManager->persist($sortie);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            $flashMesssage
        );

        return $this->redirectToRoute('liste-sorties');
    }


}
