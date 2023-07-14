<?php

namespace App\Entity;

use App\Repository\OffersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=OffersRepository::class)
 */
class Offers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $b24_contact_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $b24_deal_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $b24_manager_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $manager;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $position;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $avatar;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $status;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTime $date_end;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getB24ContactId(): ?int
    {
        return $this->b24_contact_id;
    }

    public function setB24ContactId(int $b24ContactId): self
    {
        $this->b24_contact_id = $b24ContactId;
        return $this;
    }

    public function getB24DealId(): ?int
    {
        return $this->b24_deal_id;
    }

    public function setB24DealId(int $b24DealId): self
    {
        $this->b24_deal_id = $b24DealId;
        return $this;
    }

    public function getB24ManagerId(): ?int
    {
        return $this->b24_manager_id;
    }

    public function setB24ManagerId(int $b24ManagerId): self
    {
        $this->b24_manager_id = $b24ManagerId;
        return $this;
    }

    public function getManager(): ?string
    {
        return $this->manager;
    }

    public function setManager(string $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getDate_end(): \DateTime
    {
        return $this->date_end;
    }

    public function setDate_end(\DateTime $date_end): self
    {
        $this->date_end = $date_end;
        return $this;
    }

    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTime $createAt): self
    {
        $this->createAt = $createAt;
        return $this;
    }
}
