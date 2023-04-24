<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Serializer\Annotation\SerializedName;

class UserLoginDTO
{
    #[SerializedName('userName')]
    public ?string $userName = null;

    #[SerializedName('email')]
    public ?string $email = null;

    #[SerializedName('password')]
    public string $password;
}