<?php

namespace App\Entity;

class Citoyen
{
    private ?int $id = null;
    private string $nci;
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private string $lieuNaissance;
    private ?string $urlCarteRecto = null;
    private ?string $urlCarteVerso = null;

    public function __construct(
        string $nci,
        string $nom,
        string $prenom,
        string $dateNaissance,
        string $lieuNaissance,
        ?string $urlCarteRecto = null,
        ?string $urlCarteVerso = null
    ) {
        $this->nci = $nci;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->lieuNaissance = $lieuNaissance;
        $this->urlCarteRecto = $urlCarteRecto;
        $this->urlCarteVerso = $urlCarteVerso;
    }

    public function getId(): ?int { return $this->id; }
    public function getNci(): string { return $this->nci; }
    public function setNci(string $nci): void { $this->nci = $nci; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function getDateNaissance(): string { return $this->dateNaissance; }
    public function setDateNaissance(string $dateNaissance): void { $this->dateNaissance = $dateNaissance; }
    public function getLieuNaissance(): string { return $this->lieuNaissance; }
    public function setLieuNaissance(string $lieuNaissance): void { $this->lieuNaissance = $lieuNaissance; }
    public function getUrlCarteRecto(): ?string { return $this->urlCarteRecto; }
    public function setUrlCarteRecto(?string $urlCarteRecto): void { $this->urlCarteRecto = $urlCarteRecto; }
    public function getUrlCarteVerso(): ?string { return $this->urlCarteVerso; }
    public function setUrlCarteVerso(?string $urlCarteVerso): void { $this->urlCarteVerso = $urlCarteVerso; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nci' => $this->nci,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_naissance' => $this->dateNaissance,
            'lieu_naissance' => $this->lieuNaissance,
            'url_carte_recto' => $this->urlCarteRecto,
            'url_carte_verso' => $this->urlCarteVerso,
        ];
    }

    public static function toObject(array $data): self
    {
        $citoyen = new self(
            $data['nci'] ?? '',
            $data['nom'] ?? '',
            $data['prenom'] ?? '',
            $data['date_naissance'] ?? '',
            $data['lieu_naissance'] ?? '',
            $data['url_carte_recto'] ?? null,
            $data['url_carte_verso'] ?? null
        );

        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($citoyen, (int)$data['id']);
        }

        return $citoyen;
    }
}