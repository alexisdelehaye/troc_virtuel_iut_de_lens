<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity
 */
class Profil
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprofil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomProfil", type="string", length=45, nullable=true)
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


}
