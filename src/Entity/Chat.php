<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
#[ApiResource]
class Chat
{
    #[ORM\Id]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $rating = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $reviews_count = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'rating' => $this->getRating(),
            'reviews_count' => $this->getReviewsCount(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReviewsCount(): ?int
    {
        return $this->reviews_count;
    }

    public function setReviewsCount(int $reviews_count): static
    {
        $this->reviews_count = $reviews_count;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
