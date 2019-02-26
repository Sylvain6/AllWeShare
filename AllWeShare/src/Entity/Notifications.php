<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationsRepository")
 */
class Notifications
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_sender;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_receiver;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_seen;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSender(): ?int
    {
        return $this->id_sender;
    }

    public function setIdSender(int $id_sender): self
    {
        $this->id_sender = $id_sender;

        return $this;
    }

    public function getIdReceiver(): ?int
    {
        return $this->id_receiver;
    }

    public function setIdReceiver(int $id_receiver): self
    {
        $this->id_receiver = $id_receiver;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsSeen(): ?bool
    {
        return $this->is_seen;
    }

    public function setIsSeen(bool $is_seen): self
    {
        $this->is_seen = $is_seen;

        return $this;
    }
    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(?int $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }
}
