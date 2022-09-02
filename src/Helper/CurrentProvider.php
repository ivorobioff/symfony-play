<?php

namespace App\Helper;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class CurrentProvider
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getUser(): User {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User must be instance of ' . User::class);
        }

        return $user;
    }
}