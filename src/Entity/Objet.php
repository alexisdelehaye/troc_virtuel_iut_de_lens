<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objet
 *
 * @ORM\Table(name="objet", indexes={@ORM\Index(name="idTransaction_idx", columns={"idTransaction"}), @ORM\Index(name="idUser_idx", columns={"idProprietaire"}), @ORM\Index(name="idCategorie_idx", columns={"idCategorie"})})
 * @ORM\Entity
 */
class Objet
{
    /**
     * @var int
     *
     * @ORM\Column(name="idObjet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idobjet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomObjet", type="string", length=45, nullable=true)
     */
    private $nomobjet;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptionObjet", type="text", length=65535, nullable=true)
     */
    private $descriptionobjet;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Disponible", type="boolean", nullable=true)
     */
    private $disponible;

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
     * @var \Transaction
     *
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTransaction", referencedColumnName="idtransaction")
     * })
     */
    private $idtransaction;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProprietaire", referencedColumnName="iduser")
     * })
     */
    private $idproprietaire;

    public function getIdobjet(): ?int
    {
        return $this->idobjet;
    }

    public function getNomobjet(): ?string
    {
        return $this->nomobjet;
    }

    public function setNomobjet(?string $nomobjet): self
    {
        $this->nomobjet = $nomobjet;

        return $this;
    }

    public function getDescriptionobjet(): ?string
    {
        return $this->descriptionobjet;
    }

    public function setDescriptionobjet(?string $descriptionobjet): self
    {
        $this->descriptionobjet = $descriptionobjet;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(?bool $disponible): self
    {
        $this->disponible = $disponible;

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

    public function getIdtransaction(): ?Transaction
    {
        return $this->idtransaction;
    }

    public function setIdtransaction(?Transaction $idtransaction): self
    {
        $this->idtransaction = $idtransaction;

        return $this;
    }

    public function getIdproprietaire(): ?User
    {
        return $this->idproprietaire;
    }

    public function setIdproprietaire(?User $idproprietaire): self
    {
        $this->idproprietaire = $idproprietaire;

        return $this;
    }


}
