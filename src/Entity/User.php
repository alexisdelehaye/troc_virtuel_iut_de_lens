<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ApiResource()
 * @ORM\Table(name="user", indexes={@ORM\Index(name="idProfil_idx", columns={"idProfil"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
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
     * @ORM\Column(name="passwordUser", type="text", nullable=false)
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

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $banni = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Objet", mappedBy="idproprietaire")
     */
    private $objets;

    public function __construct()
    {
        $this->objets = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->getNomuser().' '.$this->getPrenompersonne();
    }


    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return (string) $this->passworduser;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->emailuser;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isBanni(): ?bool
    {
        return $this->banni;
    }

    public function setBanni(bool $banni): self
    {
        $this->banni = $banni;

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
