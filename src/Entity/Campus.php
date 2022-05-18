<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 */
class Campus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="siteOrganisateur")
     */
    private $sortieOrganiseePar;

    public function __construct()
    {
        $this->sortieOrganiseePar = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Sortie>
     */
    public function getSortieOrganiseePar(): Collection
    {
        return $this->sortieOrganiseePar;
    }

    public function addSortieOrganiseePar(Sortie $sortieOrganiseePar): self
    {
        if (!$this->sortieOrganiseePar->contains($sortieOrganiseePar)) {
            $this->sortieOrganiseePar[] = $sortieOrganiseePar;
            $sortieOrganiseePar->setSiteOrganisateur($this);
        }

        return $this;
    }

    public function removeSortieOrganiseePar(Sortie $sortieOrganiseePar): self
    {
        if ($this->sortieOrganiseePar->removeElement($sortieOrganiseePar)) {
            // set the owning side to null (unless already changed)
            if ($sortieOrganiseePar->getSiteOrganisateur() === $this) {
                $sortieOrganiseePar->setSiteOrganisateur(null);
            }
        }

        return $this;
    }
}
