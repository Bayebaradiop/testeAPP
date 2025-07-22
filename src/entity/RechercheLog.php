<?php

namespace App\Entity;

class RechercheLog
{
    private ?int $id = null;
    private string $nci;
    private string $dateRecherche;
    private ?string $localisation = null;
    private ?string $ip = null;
    private string $statut;
    private ?string $message = null;

    public function __construct(
        string $nci,
        string $dateRecherche,
        string $statut,
        ?string $localisation = null,
        ?string $ip = null,
        ?string $message = null
    ) {
        $this->nci = $nci;
        $this->dateRecherche = $dateRecherche;
        $this->statut = $statut;
        $this->localisation = $localisation;
        $this->ip = $ip;
        $this->message = $message;
    }

    public function getId(): ?int { return $this->id; }
    public function getNci(): string { return $this->nci; }
    public function setNci(string $nci): void { $this->nci = $nci; }
    public function getDateRecherche(): string { return $this->dateRecherche; }
    public function setDateRecherche(string $dateRecherche): void { $this->dateRecherche = $dateRecherche; }
    public function getLocalisation(): ?string { return $this->localisation; }
    public function setLocalisation(?string $localisation): void { $this->localisation = $localisation; }
    public function getIp(): ?string { return $this->ip; }
    public function setIp(?string $ip): void { $this->ip = $ip; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): void { $this->message = $message; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nci' => $this->nci,
            'date_recherche' => $this->dateRecherche,
            'localisation' => $this->localisation,
            'ip' => $this->ip,
            'statut' => $this->statut,
            'message' => $this->message,
        ];
    }

    public static function toObject(array $data): self
    {
        $log = new self(
            $data['nci'] ?? '',
            $data['date_recherche'] ?? '',
            $data['statut'] ?? '',
            $data['localisation'] ?? null,
            $data['ip'] ?? null,
            $data['message'] ?? null
        );

        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($log, (int)$data['id']);
        }

        return $log;
    }
}