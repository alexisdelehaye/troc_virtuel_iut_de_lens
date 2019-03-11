<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ApiResource()
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_Conversation_has_User_User1_idx", columns={"User_idUser"}), @ORM\Index(name="fk_Conversation_has_User_Conversation1_idx", columns={"Conversation_idConversation"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMessage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmessage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=true)
     */
    private $contenu;

    /**
     * @var \Conversation
     *
     * @ORM\ManyToOne(targetEntity="Conversation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Conversation_idConversation", referencedColumnName="idconversation")
     * })
     */
    private $conversationconversation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="User_idUser", referencedColumnName="iduser")
     * })
     */
    private $useruser;

    public function getIdmessage(): ?int
    {
        return $this->idmessage;
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

    public function getConversationconversation(): ?Conversation
    {
        return $this->conversationconversation;
    }

    public function setConversationconversation(?Conversation $conversationconversation): self
    {
        $this->conversationconversation = $conversationconversation;

        return $this;
    }

    public function getUseruser(): ?User
    {
        return $this->useruser;
    }

    public function setUseruser(?User $useruser): self
    {
        $this->useruser = $useruser;

        return $this;
    }


}
