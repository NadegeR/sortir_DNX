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

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="campus", orphanRemoval=true)
     */
    private $users;

    public function __construct()
    {
        $this->sortieOrganiseePar = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCampus($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCampus() === $this) {
                $user->setCampus(null);
            }
        }

        return $this;
    }
}
