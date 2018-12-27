<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="idProfil_idx", columns={"idProfil"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="nomUser", type="string", length=45, nullable=false)
     */
    private $nomuser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomPersonne", type="string", length=45, nullable=false)
     */
    private $prenompersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="emailUser", type="string", length=45, nullable=false)
     */
    private $emailuser;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordUser", type="string", length=45, nullable=false)
     */
    private $passworduser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pseudo", type="string", length=45, nullable=true)
     */
    private $pseudo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar", type="string", length=45, nullable=true)
     */
    private $avatar;

    /**
     * @var \Profil
     *
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProfil", referencedColumnName="idprofil")
     * })
     */
    private $idprofil;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getNomuser(): ?string
    {
        return $this->nomuser;
    }

    public function setNomuser(string $nomuser): self
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    public function getPrenompersonne(): ?string
    {
        return $this->prenompersonne;
    }

    public function setPrenompersonne(string $prenompersonne): self
    {
        $this->prenompersonne = $prenompersonne;

        return $this;
    }

    public function getEmailuser(): ?string
    {
        return $this->emailuser;
    }

    public function setEmailuser(string $emailuser): self
    {
        $this->emailuser = $emailuser;

        return $this;
    }

    public function getPassworduser(): ?string
    {
        return $this->passworduser;
    }

    public function setPassworduser(string $passworduser): self
    {
        $this->passworduser = $passworduser;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIdprofil(): ?Profil
    {
        return $this->idprofil;
    }

    public function setIdprofil(?Profil $idprofil): self
    {
        $this->idprofil = $idprofil;

        return $this;
    }


}
