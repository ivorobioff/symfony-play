<?php

namespace App\Service;

use App\Entity\Artifact;
use Doctrine\ORM\EntityManagerInterface;

class ArtifactService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Artifact $artifact): void {

    }
}