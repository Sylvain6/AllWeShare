<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table("`group`")
 */
class Group
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
    private $place;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groups")
     */
    private $user_1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groups")
     */
    private $user_2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groups")
     */
    private $user_3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getUser1(): ?User
    {
        return $this->user_1;
    }

    public function setUser1(?User $user_1): self
    {
        $this->user_1 = $user_1;

        return $this;
    }

    public function getUser2(): ?User
    {
        return $this->user_2;
    }

    public function setUser2(?User $user_2): self
    {
        $this->user_2 = $user_2;

        return $this;
    }

    public function getUser3(): ?User
    {
        return $this->user_3;
    }

    public function setUser3(?User $user_3): self
    {
        $this->user_3 = $user_3;

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setSharedAccount($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->contains($request)) {
            $this->requests->removeElement($request);
            // set the owning side to null (unless already changed)
            if ($request->getSharedAccount() === $this) {
                $request->setSharedAccount(null);
            }
        }

        return $this;
    }
}
