<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use App\DTO\ReferralCodeDTO;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserCreateReferralCodeService;
use Symfony\Component\HttpFoundation\JsonResponse;

#[
    Rest\Route('/api'),
]
class UserCreateReferralCodeController extends AbstractFOSRestController
{
    #[
        Rest\Post('/create/referral'),
        OA\RequestBody(
            description: 'referral',
            required: true,
            content: new OA\JsonContent(
                ref: new Model(type: ReferralCodeDTO::class)
            )
        ),
    ]
    public function createReferral(SerializerInterface $serializer, Request $request, UserCreateReferralCodeService $userCreateReferralCodeService): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), ReferralCodeDTO::class, 'json');
        $response = $userCreateReferralCodeService->createReferralCode($user);
        return new JsonResponse($serializer->serialize($response, 'json'));
    }
}