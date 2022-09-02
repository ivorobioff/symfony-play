<?php

namespace App\Service;

use App\Entity\Artifact;
use App\Helper\CurrentProvider;
use Doctrine\ORM\EntityManagerInterface;

class ArtifactService
{
    private EntityManagerInterface $entityManager;
    private CurrentProvider $current;

    public function __construct(EntityManagerInterface $entityManager, CurrentProvider $current)
    {
        $this->entityManager = $entityManager;
        $this->current = $current;
    }

    /**
     * @return Artifact[]
     */
    public function getAll(): array {
        $artifactRepository = $this->entityManager->getRepository(Artifact::class);

        return $artifactRepository->findBy(['createdBy' => $this->current->getUser()]);
    }

    public function create(Artifact $artifact): Artifact
    {
        $artifact->setCreatedAt(new \DateTime('now', new \DateTimeZone('UTC')));
        $artifact->setCreatedBy($this->current->getUser());

        $this->entityManager->persist($artifact);
        $this->entityManager->flush();

        return $artifact;
    }

    public function get(int $id): ?Artifact {
        $artifactRepository = $this->entityManager->getRepository(Artifact::class);

        return $artifactRepository->findOneBy([
            'id' => $id, 'createdBy' => $this->current->getUser()
        ]);
    }
}