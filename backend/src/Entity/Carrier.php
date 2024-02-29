<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarrierRepository::class)]
class Carrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['safe'])]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    #[Groups(['safe'])]
    private ?string $title = null;

    #[ORM\Column]
    #[Groups(['safe'])]
    private array $deliveryRules = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDeliveryRules(): array
    {
        return $this->deliveryRules;
    }

    public function setDeliveryRules(array $deliveryRules): static
    {
        $this->deliveryRules = $deliveryRules;

        return $this;
    }
}
