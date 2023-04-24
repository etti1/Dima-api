<?php

namespace App\Controller;


use App\DTO\UserDTO;

use App\Service\UserRegistrationService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Attributes as OA;


#[
    Rest\Route('/api'),
]
class UserRegistrationController extends AbstractFOSRestController
{

    #[
        Rest\Post('/reg'),
        OA\RequestBody(
            description: 'Registration',
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: UserDTO::class)
            )
        ),
    ]
    public function registration(SerializerInterface $serializer, Request $request, UserRegistrationService $userRegistrationService): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), UserDTO::class, 'json');
        $response = $userRegistrationService->registration($user);
        return new JsonResponse($serializer->serialize($response, 'json'));
    }

}