<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $liste_de_sous_modules;

    /**
     * @ORM\ManyToMany(targetEntity=semestre::class, inversedBy="modules")
     */
    private $semestre;

    public function __construct()
    {
        $this->semestre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getListeDeSousModules(): ?string
    {
        return $this->liste_de_sous_modules;
    }

    public function setListeDeSousModules(string $liste_de_sous_modules): self
    {
        $this->liste_de_sous_modules = $liste_de_sous_modules;

        return $this;
    }

    /**
     * @return Collection|semestre[]
     */
    public function getSemestre(): Collection
    {
        return $this->semestre;
    }

    public function addSemestre(semestre $semestre): self
    {
        if (!$this->semestre->contains($semestre)) {
            $this->semestre[] = $semestre;
        }

        return $this;
    }

    public function removeSemestre(semestre $semestre): self
    {
        $this->semestre->removeElement($semestre);

        return $this;
    }
}
