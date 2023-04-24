<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\DTO\UserLoginDTO;
use App\Service\UserLoginService;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;


#[
    Rest\Route('/api'),
]
class UserLoginController extends AbstractFOSRestController
{
    #[
        Rest\Post('/login', name: 'app_login'),
        OA\RequestBody(
            description: 'login',
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: UserLoginDTO::class)
            )
        ),
    ]
    public function login(SerializerInterface $serializer, Request $request, UserLoginService $loginService): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), UserLoginDTO::class, 'json');
        $response = $loginService->login($user);
        return new JsonResponse($serializer->serialize($response, 'json'));
    }


}