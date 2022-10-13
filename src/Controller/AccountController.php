<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class AccountController extends AbstractController
{
    #[Route('/account/profile', name: 'app_account_profile')]
    public function show(): Response
    {
        return $this->render('account/show.html.twig');
    }

    /**
     * @Route("/account/edit", name="app_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Account successfuly updated !');
            return $this->redirectToRoute('app_account_profile');
        }
        return $this->render('account/edit.html.twig', [
            'user' => $user,
            'userForm' => $form->createView(),
        ]);
    }

}
