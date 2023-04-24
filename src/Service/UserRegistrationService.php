<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\DTO\UserResponseDTO;
use App\DTOBuilder\UserDTOBuilder;
use App\Exception\ExceptionUser;
use App\Manager\UserManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

readonly class UserRegistrationService
{



    public function __construct
    (
        private UserDTOBuilder $builder,
        private UserPasswordHasherInterface $passwordHasher,
        private UserManager $userManager,
        private JWTTokenManagerInterface $jwtTokenManager
    )
    {
    }

    public function registration(UserDTO $userDTO): UserResponseDTO
    {
        $user = $this->builder->buildEntity($userDTO);
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        if (!filter_var($userDTO->email, FILTER_VALIDATE_EMAIL)) {
            throw new ExceptionUser(400, 'invalid email');
        }
        if (!strlen($userDTO->password < 5) || !preg_match('/[a-zA-Z]/', $userDTO->password)) {
            throw new ExceptionUser(401, 'invalid password');
        } else {
            $user->setReferralCode(uniqid('ref', true));
            $this->userManager->create($user);
        }
        $accessToken = $this->jwtTokenManager->create($user);
        return new UserResponseDTO($accessToken);
    }
}