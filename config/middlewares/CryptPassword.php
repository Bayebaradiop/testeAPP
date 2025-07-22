<?php

namespace App\middlewares;

class CryptPassword
{
    public static function crypt(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }


    public function __invoke()
    {
        if (isset($_POST['password'])) {
            $_POST['password'] = self::crypt($_POST['password']);
        }
    }
}

