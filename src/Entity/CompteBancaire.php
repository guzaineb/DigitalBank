<?php

namespace App\Entity;

use App\Repository\CompteBancaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteBancaireRepository::class)]
class CompteBancaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CompteBancaire;

    #[ORM\Column]
    private ?float $numero_compte ;

    #[ORM\Column]
    private ?\DateTimeImmutable $cratted_at ;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at ;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\OneToOne(mappedBy: 'compte_bancaire_id', cascade: ['persist', 'remove'])]
    private ?Solde $solde_id = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'compte_bancaie_id')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompteBancaire(): ?string
    {
        return $this->CompteBancaire;
    }

    public function setCompteBancaire(string $CompteBancaire): static
    {
        $this->CompteBancaire = $CompteBancaire;

        return $this;
    }

    public function getNumeroCompte(): ?float
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(float $numero_compte): static
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getCrattedAt(): ?\DateTimeImmutable
    {
        return $this->cratted_at;
    }

    public function setCrattedAt(\DateTimeImmutable $cratted_at): static
    {
        $this->cratted_at = $cratted_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSoldeId(): ?Solde
    {
        return $this->solde_id;
    }

    public function setSoldeId(Solde $solde_id): static
    {
        // set the owning side of the relation if necessary
        if ($solde_id->getCompteBancaireId() !== $this) {
            $solde_id->setCompteBancaireId($this);
        }

        $this->solde_id = $solde_id;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setCompteBancaieId($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompteBancaieId() === $this) {
                $transaction->setCompteBancaieId(null);
            }
        }

        return $this;
    }
}
