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
    private ?string $compteBancaire = null;

    #[ORM\Column]
    private ?string $numero_compte = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comptesBancaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'compteBancaire', cascade: ['persist', 'remove'])]
    private ?Solde $solde = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'compte_bancaire_id')]
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
        return $this->compteBancaire;
    }

    public function setCompteBancaire(string $compteBancaire): static
    {
        $this->compteBancaire = $compteBancaire;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): static
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSolde(): ?Solde
    {
        return $this->solde;
    }

    public function setSolde(Solde $solde): static
    {
        if ($solde->getCompteBancaire() !== $this) {
            $solde->setCompteBancaire($this);
        }

        $this->solde = $solde;

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
            $transaction->setCompteBancaire($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompteBancaire() === $this) {
                $transaction->setCompteBancaire(null);
            }
        }

        return $this;
    }

    /**
     * Ajoute un montant au solde actuel.
     */
    public function ajouterAuSolde(float $montant): static
    {
        if ($this->solde === null) {
            $this->solde = new Solde();
            $this->solde->setCompteBancaire($this);
        }
        
        $nouveauMontant = $this->solde->getMontant() + $montant;
        $this->solde->setMontant($nouveauMontant);

        return $this;
    }
    public function effectuerTransaction(Transaction $transaction): void
{
    // Débit du compte du donneur
    $montantADebiter = $transaction->getMontant();
    $this->ajouterAuSolde(-$montantADebiter);

    // Crédit du compte du récepteur
    $recepteur = $transaction->getIdRecepteur();
    $recepteur->ajouterAuSolde($montantADebiter);
    
}


}

