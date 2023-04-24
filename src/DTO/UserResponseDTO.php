<?php

namespace App\DTO;

use JMS\Serializer\Annotation\SerializedName;

readonly class UserResponseDTO
{
    #[SerializedName('access_token')]
    public string $accessToken;

    public function __construct(
        string $accessToken
    ) {
        $this->accessToken = $accessToken;
    }
}