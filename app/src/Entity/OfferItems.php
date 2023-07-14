<?php

namespace App\Entity;

use App\Repository\OfferItemsRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=OfferItemsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class OfferItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Offers::class)
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private Offers $offer;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $cid;

    /**
     * @ORM\Column(type="smallint", length=1)
     */
    private int $type;

    /**
     * @ORM\Column(type="float")
     */
    private float $square;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $complex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $house;

    /**
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=true)
     */
    private string $description;

    /**
     * @ORM\Column(type="json")
     */
    private array $images = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $liked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfferId(): Offers
    {
        return $this->offer;
    }

    public function setOfferId(Offers $offerId): self
    {
        $this->offer = $offerId;
        return $this;
    }

    public function getCid(): string
    {
        return $this->cid;
    }

    public function setCid(string $cId): self
    {
        $this->cid = $cId;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getSquare(): float
    {
        return $this->square;
    }

    public function setSquare(float $square): self
    {
        $this->square = $square;
        return $this;
    }

    public function getComplex(): string
    {
        return $this->complex;
    }

    public function setComplex(string $complex): self
    {
        $this->complex = $complex;
        return $this;
    }

    public function getHouse(): string
    {
        return $this->house;
    }

    public function setHouse(string $house): self
    {
        $this->house = $house;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;
        return $this;
    }

    public function getLike(): bool
    {
        return $this->liked;
    }

    public function setLike(bool $like): self
    {
        $this->liked = $like;
        return $this;
    }
}

