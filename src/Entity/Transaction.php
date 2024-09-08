<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_transaction = null;

    /**
     * @var Collection<int, HistoriqueTransaction>
     */
    #[ORM\OneToMany(targetEntity: HistoriqueTransaction::class, mappedBy: 'transaction_id')]
    private Collection $historiqueTransactions;



    #[ORM\ManyToOne(targetEntity: CompteBancaire::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_donneur')]
    private ?CompteBancaire $id_donneur = null;
    
    #[ORM\ManyToOne(targetEntity: CompteBancaire::class)]
    #[ORM\JoinColumn(nullable: false, name: 'id_recepteur')]
    private ?CompteBancaire $id_recepteur = null;
    
    #[ORM\Column(type: Types::STRING, length: 100, unique: true)]
     private ?string $reference = null;


    public function __construct()
    {
        $this->historiqueTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->date_transaction;
    }

    public function setDateTransaction(\DateTimeInterface $date_transaction): static
    {
        $this->date_transaction = $date_transaction;

        return $this;
    }

  
  

    /**
     * @return Collection<int, HistoriqueTransaction>
     */
    public function getHistoriqueTransactions(): Collection
    {
        return $this->historiqueTransactions;
    }

    public function addHistoriqueTransaction(HistoriqueTransaction $historiqueTransaction): static
    {
        if (!$this->historiqueTransactions->contains($historiqueTransaction)) {
            $this->historiqueTransactions->add($historiqueTransaction);
            $historiqueTransaction->setTransactionId($this);
        }

        return $this;
    }

    public function removeHistoriqueTransaction(HistoriqueTransaction $historiqueTransaction): static
    {
        if ($this->historiqueTransactions->removeElement($historiqueTransaction)) {
            // set the owning side to null (unless already changed)
            if ($historiqueTransaction->getTransactionId() === $this) {
                $historiqueTransaction->setTransactionId(null);
            }
        }

        return $this;
    }

    public function getReference(): ?string
{
    return $this->reference;
}

public function setReference(string $reference): static
{
    $this->reference = $reference;

    return $this;
}


// Autres champs et méthodes...

public function getIdDonneur(): ?CompteBancaire
{
    return $this->id_donneur;
}

public function setIdDonneur(?CompteBancaire $id_donneur): static
{
    $this->id_donneur = $id_donneur;

    return $this;
}

public function getIdRecepteur(): ?CompteBancaire
{
    return $this->id_recepteur;
}

public function setIdRecepteur(?CompteBancaire $id_recepteur): static
{
    $this->id_recepteur = $id_recepteur;

    return $this;
}



   

}
