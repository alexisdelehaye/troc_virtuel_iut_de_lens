<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="idTypeTransaction_idx", columns={"idTypeTranasaction"}), @ORM\Index(name="idUserDemandeur_idx", columns={"idUserDemandeur"}), @ORM\Index(name="idUserOffrant_idx", columns={"idUserOffrant"}), @ORM\Index(name="idObjet_idx", columns={"idObjet"})})
 * @ORM\Entity
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtransaction", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtransaction;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="transactionRealisÃ©e", type="boolean", nullable=true)
     */
    private $transactionrealisã©e;

    /**
     * @var \Objet
     *
     * @ORM\ManyToOne(targetEntity="Objet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idObjet", referencedColumnName="idobjet")
     * })
     */
    private $idobjet;

    /**
     * @var \Typetransaction
     *
     * @ORM\ManyToOne(targetEntity="Typetransaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeTranasaction", referencedColumnName="idtypetransaction")
     * })
     */
    private $idtypetranasaction;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUserDemandeur", referencedColumnName="iduser")
     * })
     */
    private $iduserdemandeur;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUserOffrant", referencedColumnName="iduser")
     * })
     */
    private $iduseroffrant;

    public function getIdtransaction(): ?int
    {
        return $this->idtransaction;
    }

    public function getTransactionrealisã©e(): ?bool
    {
        return $this->transactionrealisã©e;
    }

    public function setTransactionrealisã©e(?bool $transactionrealisã©e): self
    {
        $this->transactionrealisã©e = $transactionrealisã©e;

        return $this;
    }

    public function getIdobjet(): ?Objet
    {
        return $this->idobjet;
    }

    public function setIdobjet(?Objet $idobjet): self
    {
        $this->idobjet = $idobjet;

        return $this;
    }

    public function getIdtypetranasaction(): ?Typetransaction
    {
        return $this->idtypetranasaction;
    }

    public function setIdtypetranasaction(?Typetransaction $idtypetranasaction): self
    {
        $this->idtypetranasaction = $idtypetranasaction;

        return $this;
    }

    public function getIduserdemandeur(): ?User
    {
        return $this->iduserdemandeur;
    }

    public function setIduserdemandeur(?User $iduserdemandeur): self
    {
        $this->iduserdemandeur = $iduserdemandeur;

        return $this;
    }

    public function getIduseroffrant(): ?User
    {
        return $this->iduseroffrant;
    }

    public function setIduseroffrant(?User $iduseroffrant): self
    {
        $this->iduseroffrant = $iduseroffrant;

        return $this;
    }


}
