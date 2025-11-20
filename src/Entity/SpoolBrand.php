<?php

namespace App\Entity;

use App\Repository\SpoolBrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpoolBrandRepository::class)]
class SpoolBrand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    /**
     * @var Collection<int, Spool>
     */
    #[ORM\OneToMany(targetEntity: Spool::class, mappedBy: 'spoolBrand')]
    private Collection $spools;

    public function __construct()
    {
        $this->spools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, Spool>
     */
    public function getSpools(): Collection
    {
        return $this->spools;
    }

    public function addSpool(Spool $spool): static
    {
        if (!$this->spools->contains($spool)) {
            $this->spools->add($spool);
            $spool->setSpoolBrand($this);
        }

        return $this;
    }

    public function removeSpool(Spool $spool): static
    {
        if ($this->spools->removeElement($spool)) {
            // set the owning side to null (unless already changed)
            if ($spool->getSpoolBrand() === $this) {
                $spool->setSpoolBrand(null);
            }
        }

        return $this;
    }
}
