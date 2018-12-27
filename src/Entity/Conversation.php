<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conversation
 *
 * @ORM\Table(name="conversation", indexes={@ORM\Index(name="idObjetConcerne_idx", columns={"idObjetConcerne"}), @ORM\Index(name="idEnvoyeur_idx", columns={"idEnvoyeur"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ConversationRepository")
 */
class Conversation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idConversation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconversation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date", type="text", length=65535, nullable=true)
     */
    private $date;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEnvoyeur", referencedColumnName="iduser")
     * })
     */
    private $idenvoyeur;

    /**
     * @var \Objet
     *
     * @ORM\ManyToOne(targetEntity="Objet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idObjetConcerne", referencedColumnName="idobjet")
     * })
     */
    private $idobjetconcerne;

    public function getIdconversation(): ?int
    {
        return $this->idconversation;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdenvoyeur(): ?User
    {
        return $this->idenvoyeur;
    }

    public function setIdenvoyeur(?User $idenvoyeur): self
    {
        $this->idenvoyeur = $idenvoyeur;

        return $this;
    }

    public function getIdobjetconcerne(): ?Objet
    {
        return $this->idobjetconcerne;
    }

    public function setIdobjetconcerne(?Objet $idobjetconcerne): self
    {
        $this->idobjetconcerne = $idobjetconcerne;

        return $this;
    }


}
