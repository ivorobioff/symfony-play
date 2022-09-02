<?php

namespace App\Service;

use App\Entity\Artifact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ArtifactService
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function create(Artifact $artifact): Artifact
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User must be instance of ' . User::class);
        }

        $artifact->setCreatedAt(new \DateTime('now', new \DateTimeZone('UTC')));

        $artifact->setCreatedBy($user);

        $this->entityManager->persist($artifact);
        $this->entityManager->flush();

        return $artifact;
    }

    public function get(int $id): ?Artifact {
        return $this->entityManager->find(Artifact::class, $id);
    }
}