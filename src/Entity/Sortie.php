<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
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
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbIscriptionsMax;

    /**
     * @ORM\Column(type="text")
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $siteOrganisateur;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="isInscrit")
     */
    private $participants;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="organisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateurs;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbIscriptionsMax(): ?int
    {
        return $this->nbIscriptionsMax;
    }

    public function setNbIscriptionsMax(int $nbIscriptionsMax): self
    {
        $this->nbIscriptionsMax = $nbIscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getSiteOrganisateur(): ?Campus
    {
        return $this->siteOrganisateur;
    }

    public function setSiteOrganisateur(?Campus $siteOrganisateur): self
    {
        $this->siteOrganisateur = $siteOrganisateur;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->addIsInscrit($this);
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            $participant->removeIsInscrit($this);
        }

        return $this;
    }

    public function getOrganisateurs(): ?User
    {
        return $this->organisateurs;
    }

    public function setOrganisateurs(?User $organisateurs): self
    {
        $this->organisateurs = $organisateurs;

        return $this;
    }

    public function modifierEtat (Sortie $sortie, EntityManager $entityManager)
    {
        $maintenant = new \DateTime();
        $minutes = $sortie->getDuree();
        $dateCloture = $sortie->getDateLimiteInscription();

        $debutSortie = $sortie->getDateHeureDebut();
        $debutSortieString = $debutSortie->format('d/m/Y H:i');

        $temps = strtotime("+{$minutes} minutes",strtotime($debutSortieString));
        $dateDeFin = new \DateTime();
        $dateDeFin->setTimestamp($temps);
        $dateDeFinString = $dateDeFin->format('d/m/Y H:i');

        $tempsArchive = strtotime('+1 month', strtotime($dateDeFinString));
        $archivage = new \DateTime();
        $archivage->setTimestamp($tempsArchive);

        $libelleEtat = '';

        if($sortie->getEtat()->getLibelle() != Etat::CREE && $sortie->getEtat()->getLibelle() != Etat::ANNULEE)
        {
            if($sortie->getParticipants()->count() >= $sortie->getNbIscriptionsMax())
            {
                $libelleEtat = Etat::CLOTUREE;
            }
            else{
                $libelleEtat = Etat::OUVERTE;
            }

            if($dateCloture < $maintenant && $debutSortie > $maintenant)
            {
                $libelleEtat = Etat::CLOTUREE;
            }
            elseif ($debutSortie <= $maintenant && $dateDeFin >= $maintenant)
            {
                $libelleEtat = Etat::EN_COURS;
            }
            elseif ($debutSortie < $maintenant && $maintenant <= $archivage)
            {
                $libelleEtat = Etat::PASSEE;
            }
            elseif ($maintenant > $archivage)
            {
                $libelleEtat = Etat::ARCHIVEE;
            }




        }









    }

}
