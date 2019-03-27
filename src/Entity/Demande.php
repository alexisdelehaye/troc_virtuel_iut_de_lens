<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande", indexes={@ORM\Index(name="FK_demande_typetransaction", columns={"idTypeTransaction"}), @ORM\Index(name="FK_demande_user", columns={"idUser"}), @ORM\Index(name="FK_demande_categorie", columns={"idCategorie"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDemande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddemande;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nomDemande", type="text", length=65535, nullable=true)
     */
    private $nomdemande;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDemande", type="date", nullable=true)
     */
    private $datedemande;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="DemandeSatisfaite", type="boolean", nullable=true)
     */
    private $demandesatisfaite;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategorie", referencedColumnName="idcategorie")
     * })
     */
    private $idcategorie;

    /**
     * @var \Typetransaction
     *
     * @ORM\ManyToOne(targetEntity="Typetransaction", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTypeTransaction", referencedColumnName="idtypetransaction")
     * })
     */
    private $idtypetransaction;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="iduser")
     * })
     */
    private $iduser;

    public function getIddemande(): ?int
    {
        return $this->iddemande;
    }

    public function getNomdemande(): ?string
    {
        return $this->nomdemande;
    }

    public function setNomdemande(?string $nomdemande): self
    {
        $this->nomdemande = $nomdemande;

        return $this;
    }

    public function getDatedemande(): ?\DateTimeInterface
    {
        return $this->datedemande;
    }

    public function setDatedemande(?\DateTimeInterface $datedemande): self
    {
        $this->datedemande = $datedemande;

        return $this;
    }

    public function getDemandesatisfaite(): ?bool
    {
        return $this->demandesatisfaite;
    }

    public function setDemandesatisfaite(?bool $demandesatisfaite): self
    {
        $this->demandesatisfaite = $demandesatisfaite;

        return $this;
    }

    public function getIdcategorie(): ?Categorie
    {
        return $this->idcategorie;
    }

    public function setIdcategorie(?Categorie $idcategorie): self
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    public function getIdtypetransaction(): ?Typetransaction
    {
        return $this->idtypetransaction;
    }

    public function setIdtypetransaction(?Typetransaction $idtypetransaction): self
    {
        $this->idtypetransaction = $idtypetransaction;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
