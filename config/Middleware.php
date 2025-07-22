<?php

namespace App\Config;

use App\middlewares\Auth;
use App\middlewares\CryptPassword;

class Middleware
{
    public static function getMiddlewares(): array
    {
        return [
            'auth' => new Auth(),
            'cryptPassword' => new CryptPassword(),
        ];
    }
}