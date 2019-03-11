<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Photo
 *
 * @ApiResource()
 * @ORM\Table(name="photo", indexes={@ORM\Index(name="fk_Photo_Objet1_idx", columns={"Objet_idObjet"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPhoto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idphoto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cheminPhoto", type="text", length=65535, nullable=true)
     */
    private $cheminphoto;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="imagePrincipale", type="boolean", nullable=true)
     */
    private $imageprincipale;

    /**
     * @var \Objet
     *
     * @ORM\ManyToOne(targetEntity="Objet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Objet_idObjet", referencedColumnName="idobjet")
     * })
     */
    private $objetobjet;

    public function getIdphoto(): ?int
    {
        return $this->idphoto;
    }

    /**
     * @return mixed
     */
    public function getCheminphoto()
    {
        return $this->cheminphoto;
    }

    public function setCheminphoto(?string $cheminphoto): self
    {
        $this->cheminphoto = $cheminphoto;

        return $this;
    }

    public function getImageprincipale(): ?bool
    {
        return $this->imageprincipale;
    }

    public function setImageprincipale(?bool $imageprincipale): self
    {
        $this->imageprincipale = $imageprincipale;

        return $this;
    }

    public function getObjetobjet(): ?Objet
    {
        return $this->objetobjet;
    }

    public function setObjetobjet(?Objet $objetobjet): self
    {
        $this->objetobjet = $objetobjet;

        return $this;
    }


}
