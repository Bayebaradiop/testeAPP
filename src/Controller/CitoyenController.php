<?php

namespace App\Controller;

use App\Service\CitoyenService;

class CitoyenController
{
    private CitoyenService $citoyenService;

    public function __construct()
    {
        $this->citoyenService = new CitoyenService();
    }

    public function findByNci(string $nci)
    {
        header('Content-Type: application/json');
        $citoyen = $this->citoyenService->findByNci($nci);

        if ($citoyen) {
            http_response_code(200);
            echo json_encode([
                'data' => [
                    'nci' => $citoyen->getNci(),
                    'nom' => $citoyen->getNom(),
                    'prenom' => $citoyen->getPrenom(),
                    'date' => $citoyen->getDateNaissance(),
                    'lieu' => $citoyen->getLieuNaissance(),
                    'url_carte_recto' => $citoyen->getUrlCarteRecto(),
                    'url_carte_verso' => $citoyen->getUrlCarteVerso(),
                ],
                'statut' => 'success',
                'code' => 200,
                'message' => "Le numéro de carte d'identité a été retrouvé"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => "Le numéro de carte d'identité non retrouvé"
            ]);
        }
    }


    public function findAll()
    {
        header('Content-Type: application/json');
        $citoyens = $this->citoyenService->findAll();

        if ($citoyens) {
            http_response_code(200);
            echo json_encode([
                'data' => array_map(fn($citoyen) => $citoyen->toArray(), $citoyens),
                'statut' => 'success',
                'code' => 200,
                'message' => "Liste des citoyens récupérée avec succès"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => "Aucun citoyen trouvé"
            ]);
        }
    }

}