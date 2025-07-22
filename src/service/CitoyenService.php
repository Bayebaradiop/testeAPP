<?php

namespace App\Service;

use App\Core\App;
use App\Entity\Citoyen;
use App\Ripository\CitoyenRipository;

class CitoyenService
{
    private $citoyenRepository;

    public function __construct()
    {
        $this->citoyenRepository = new CitoyenRipository();
    }

    public function findByNci(string $nci): ?Citoyen
    {
        return $this->citoyenRepository->findByNci($nci);
    }
    public function findAll(): array
    {
        return $this->citoyenRepository->findAll();
    }

}
