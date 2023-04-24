<?php

namespace App\Service;

use App\DTO\ReferralCodeDTO;
use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Exception\ExceptionUser;
use App\Manager\UserManager;

class UserCreateReferralCodeService extends AbstractFOSRestController
{

    public function __construct
    (
        private UserManager $userManager
    )
    {
    }

    public function createReferralCode(ReferralCodeDTO $referralCodeDTO): string
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new ExceptionUser(401, 'user not logged');
        }
        $user = $user->setReferralCode($referralCodeDTO->referralCode);
        $this->userManager->update($user);

        return $user->getReferralCode();
    }
}