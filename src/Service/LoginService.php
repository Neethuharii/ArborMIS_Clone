<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class LoginService
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function authenticate(string $email, string $password)
    {
        $user = $this->usersRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return [
                'success' => false,
                'emailError' => 'Email does not exist.',
                'passwordError' => null,
            ];
        }
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            return [
                'success' => false,
                'emailError' => null,
                'passwordError' => 'Password is incorrect.',
            ];
        }
        return [
            'success' => true,
            'emailError' => null,
            'passwordError' => null,
        ];
    }

}
