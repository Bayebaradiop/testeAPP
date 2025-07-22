<?php
namespace App\Core;
use PDO;
class AbstracteRipository{
    protected PDO $pdo;
    public function __construct()
    {
        $this->pdo = App::getDependency('database');
    }


}




