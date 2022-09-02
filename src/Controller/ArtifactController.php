<?php

namespace App\Controller;

use App\Entity\Artifact;
use App\Form\ArtifactForm;
use App\Service\ArtifactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtifactController extends AbstractController
{
    private ArtifactService $artifactService;

    public function __construct(ArtifactService $artifactService)
    {
        $this->artifactService = $artifactService;
    }

    #[Route(['/artifacts', '/'], name: 'artifact_index', methods: 'GET')]
    public function index(): Response {
        return $this->render('artifact/index.html.twig', ['artifacts' => $this->artifactService->getAll()]);
    }

    #[Route(['/artifacts/create'], name: 'artifact_create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response {

        $artifact = new Artifact();

        $form = $this->createForm(ArtifactForm::class, $artifact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artifact = $this->artifactService->create($artifact);
            return $this->redirectToRoute('artifact_view', ['id'  => $artifact->getId()]);
        }

        return $this->renderForm('artifact/create.html.twig', ['form' => $form]);
    }

    #[Route(['/artifacts/{id}'], name: 'artifact_view', requirements: ['id' => '\d+'], methods: 'GET')]
    public function view(int $id): Response
    {
        $artifact = $this->artifactService->get($id);

        if (!$artifact) {
            throw $this->createNotFoundException('Artifact not found!');
        }

        return $this->render('artifact/view.html.twig', ['artifact' => $artifact]);
    }
}