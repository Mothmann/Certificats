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
     * @ORM\ManyToOne(targetEntity=Semestre::class)
     */
    private $Semestre;




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

    public function getSemestre(): ?Semestre
    {
        return $this->Semestre;
    }

    public function setSemestre(?Semestre $Semestre): self
    {
        $this->Semestre = $Semestre;

        return $this;
    }

}
