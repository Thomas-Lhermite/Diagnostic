<?php

namespace App\Entity;

use DateTimeInterface;
use App\Entity\Actuality;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActualityRepository;

#[ORM\Entity(repositoryClass: ActualityRepository::class)]
class Actuality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    private ?int $Importance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $DateAj = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImportance(): ?int
    {
        return $this->Importance;
    }

    public function setImportance(?int $Importance): self
    {
        $this->Importance = $Importance;

        return $this;
    }

    public function getDateAj(): ?\DateTimeInterface
    {
        return $this->DateAj;
    }

    public function setDateAj(\DateTimeInterface $DateAj): self
    {
        $this->DateAj = $DateAj;

        return $this;
    }
}
