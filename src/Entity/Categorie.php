<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="categories")
     * @ORM\JoinColumn(name="id", referencedColumnName="idcategorie")
     */
    private $categoriePere;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categorie", mappedBy="categoriePere")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Objet", mappedBy="idcategorie")
     */
    private $objets;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->objets = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->nomcategorie;
    }

    public function getCategoriePere(): ?self
    {
        return $this->categoriePere;
    }

    public function setCategoriePere(?self $categoriePere): self
    {
        $this->categoriePere = $categoriePere;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCategoriePere($this);
        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getCategoriePere() === $this) {
                $category->setCategoriePere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Objet[]
     */
    public function getObjets(): Collection
    {
        return $this->objets;
    }

}
