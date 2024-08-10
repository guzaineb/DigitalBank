<?php

namespace App\Entity;

use App\Repository\SoldeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoldeRepository::class)]
class Solde
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'solde_id', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompteBancaire $compte_bancaire_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteBancaireId(): ?CompteBancaire
    {
        return $this->compte_bancaire_id;
    }

    public function setCompteBancaireId(CompteBancaire $compte_bancaire_id): static
    {
        $this->compte_bancaire_id = $compte_bancaire_id;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }
}
