<?php

namespace App\Entity;

use App\Repository\SpoolRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpoolRepository::class)]
class Spool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'spools')]
    private ?SpoolBrand $spoolBrand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getSpoolBrand(): ?SpoolBrand
    {
        return $this->spoolBrand;
    }

    public function setSpoolBrand(?SpoolBrand $spoolBrand): static
    {
        $this->spoolBrand = $spoolBrand;

        return $this;
    }
}
