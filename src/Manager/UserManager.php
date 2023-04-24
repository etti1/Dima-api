<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;

readonly class UserManager
{
    public function __construct
    (
        private UserRepository $userRepository
    )
    {
    }

    public function create(User $user): User
    {
        return $this->userRepository->add($user, true);

    }

    public function update(User $user): User
    {
        return $this->userRepository->save($user);
    }

    public function findByUserUsername(string $userName): ?User
    {
        return $this->userRepository->findOneBy(['userName' => $userName]);

    }

    public function findByUserEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

}