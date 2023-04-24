<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UserDTO
{

    #[SerializedName('userName')]
    public string $userName;

    #[SerializedName('email')]
    public string $email;

    #[SerializedName('password')]
    public string $password;

}