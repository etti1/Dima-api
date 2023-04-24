<?php

namespace App\DTOBuilder;

use App\DTO\UserDTO;
use App\Entity\User;

class UserDTOBuilder
{
    public function buildEntity(UserDTO $userDTO): User
    {
        return User::create($userDTO->userName, $userDTO->email, $userDTO->password);
    }
}