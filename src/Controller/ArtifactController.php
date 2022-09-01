<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtifactController extends AbstractController
{
    #[Route(['/artifacts', '/'], name: 'artifact_index')]
    public function index(): Response {
        return $this->render('artifact/index.html.twig', []);
    }
}