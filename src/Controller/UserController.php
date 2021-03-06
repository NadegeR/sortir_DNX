<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController implements PasswordUpgraderInterface
{
    /**
     * @Route("/admin", name="admin_liste_users", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profil/{id}", name="details_profil", methods={"GET"})
     */
    public function afficherProfil(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/editer/{id}", name="editer_profil", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newPassword = $form->get('plainPassword')->getData();
            if ($newPassword) {
                // modification du mot de passe dans edition du profil
                $mdpEncode = $userPasswordHasher->hashPassword(
                    $user,
                    $newPassword);
                $user->setPassword($mdpEncode);
            }


            $photoFile = $form->get('photo')->getData();
            // prise en charge de l'image
            if ($photoFile) {
                $photoName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($photoName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // on deplace l'image vers le dossier photos
                // photos_directory est defini dans config/service.yaml
                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                // on hydrate le nom de l'image dans le participant
                $user->setPhoto($newFilename);
            }
            $userRepository->add($user, true);
            $this->addFlash('success','Votre profil a ??t?? modifi?? !');

            return $this->redirectToRoute('details_profil', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/effacer/{id}", name="admin_effacer_profil", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('admin_liste_users', [], Response::HTTP_SEE_OTHER);
    }
}
