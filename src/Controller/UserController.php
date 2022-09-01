<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/sign-up', name: 'user_register')]
    public function register(Request $request, UserService $userService): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->register($user);
            return $this->redirectToRoute('auth_login');
        }

        return $this->renderForm('user/register.html.twig', ['form' => $form]);
    }
}
