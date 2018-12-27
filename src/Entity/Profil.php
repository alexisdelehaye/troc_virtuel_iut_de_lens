<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ProfilRepository")
 */
class Profil
{
    /**
     *
     * @ORM\Column(name="idprofil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprofil;

    /**
     *
     * @ORM\Column(name="nomprofil", type="string", length=45, nullable=true)
     */
    private $nomprofil;

    public function getIdprofil(): ?int
    {
        return $this->idprofil;
    }

    public function getNomprofil(): ?string
    {
        return $this->nomprofil;
    }

    public function setNomprofil(?string $nomprofil): self
    {
        $this->nomprofil = $nomprofil;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomprofil();
        // TODO: Implement __toString() method.
    }


}
