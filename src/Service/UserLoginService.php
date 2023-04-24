<?php

namespace App\Service;


use App\DTO\UserLoginDTO;
use App\DTO\UserResponseDTO;
use App\Entity\User;
use App\Exception\ExceptionUser;
use App\Manager\UserManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

readonly class UserLoginService
{

    public function __construct
    (
        private UserManager $userManager,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $tokenManager
    )
    {
    }

    public function login(UserLoginDTO $userDTO): UserResponseDTO
    {
        if (empty($userDTO->email) && empty($userDTO->userName)) {
            throw new ExceptionUser(401, 'email or username must be provided');
        }

        $user = null;

        if (!empty($userDTO->email)) {
            $user = $this->userManager->findByUserEmail($userDTO->email);
        }

        if (!$user instanceof User && !empty($userDTO->userName)) {
            $user = $this->userManager->findByUserUsername($userDTO->userName);
        }

        if (!$user instanceof User) {
            throw new ExceptionUser(401, 'invalid email or username');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $userDTO->password)) {
            throw new ExceptionUser(401, 'invalid password');
        }
        return new UserResponseDTO($this->tokenManager->create($user));
    }
}

