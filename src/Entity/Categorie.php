<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomCategorie", type="string", length=45, nullable=true)
     */
    private $nomcategorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptionCategorie", type="text", length=65535, nullable=true)
     */
    private $descriptioncategorie;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(?string $nomcategorie): self
    {
        $this->nomcategorie = $nomcategorie;

        return $this;
    }

    public function getDescriptioncategorie(): ?string
    {
        return $this->descriptioncategorie;
    }

    public function setDescriptioncategorie(?string $descriptioncategorie): self
    {
        $this->descriptioncategorie = $descriptioncategorie;

        return $this;
    }


}
