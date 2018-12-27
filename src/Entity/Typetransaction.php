<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typetransaction
 *
 * @ORM\Table(name="typetransaction")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TypeTransactionRepository")
 */
class Typetransaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="idtypetransaction", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtypetransaction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomTransaction", type="string", length=45, nullable=true)
     */
    private $nomtransaction;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateDebutTransaction", type="date", nullable=true)
     */
    private $datedebuttransaction;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateFinTransaction", type="date", nullable=true)
     */
    private $datefintransaction;

    public function getIdtypetransaction(): ?int
    {
        return $this->idtypetransaction;
    }

    public function getNomtransaction(): ?string
    {
        return $this->nomtransaction;
    }

    public function setNomtransaction(?string $nomtransaction): self
    {
        $this->nomtransaction = $nomtransaction;

        return $this;
    }

    public function getDatedebuttransaction(): ?\DateTimeInterface
    {
        return $this->datedebuttransaction;
    }

    public function setDatedebuttransaction(?\DateTimeInterface $datedebuttransaction): self
    {
        $this->datedebuttransaction = $datedebuttransaction;

        return $this;
    }

    public function getDatefintransaction(): ?\DateTimeInterface
    {
        return $this->datefintransaction;
    }

    public function setDatefintransaction(?\DateTimeInterface $datefintransaction): self
    {
        $this->datefintransaction = $datefintransaction;

        return $this;
    }


}
