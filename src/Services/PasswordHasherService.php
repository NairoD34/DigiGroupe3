<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class PasswordHasherService 
{
    public function __construct(
        private UserPasswordHasherInterface $userPwdHasher
    )
    {}

    public function userHashPassword (
        User $user 
    ) : User
    {
        $rawPwd = $user->getPassword();
        $hashPwd = $this->userPwdHasher->hashPassword(
            $user,
            $rawPwd,
        );
        $user->setPassword($hashPwd);
        return $user;
    }
}
