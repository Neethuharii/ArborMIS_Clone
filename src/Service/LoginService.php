<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;

final class LoginService
{
    public function __construct(
        private readonly UsersRepository $usersRepository
    ) {
    }

    public function authenticate(
        string $email,
        string $password
    ): bool {
        $user = $this->usersRepository->findOneBy([
            'email' => $email,
        ]);

        if ($user === null) {
            return false;
        }

       return $password === $user->getPassword();
    }
}
