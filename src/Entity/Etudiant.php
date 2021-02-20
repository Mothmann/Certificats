<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $code_apogee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addresse;

    /**
     * @ORM\Column(type="date")
     */
    private $annee_1ere_inscription_universite;

    /**
     * @ORM\Column(type="date")
     */
    private $annee_1ere_inscription_enseignement_superieur;

    /**
     * @ORM\Column(type="date")
     */
    private $annee_1ere_inscription_universite_marocaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_bac;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serie_bac;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="etudiants")
     */
    private $filiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeApogee(): ?string
    {
        return $this->code_apogee;
    }

    public function setCodeApogee(string $code_apogee): self
    {
        $this->code_apogee = $code_apogee;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCne(): ?string
    {
        return $this->cne;
    }

    public function setCne(string $cne): self
    {
        $this->cne = $cne;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getVilleNaissance(): ?string
    {
        return $this->ville_naissance;
    }

    public function setVilleNaissance(string $ville_naissance): self
    {
        $this->ville_naissance = $ville_naissance;

        return $this;
    }

    public function getPaysNaissance(): ?string
    {
        return $this->pays_naissance;
    }

    public function setPaysNaissance(string $pays_naissance): self
    {
        $this->pays_naissance = $pays_naissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getAnnee1ereInscriptionUniversite(): ?\DateTimeInterface
    {
        return $this->annee_1ere_inscription_universite;
    }

    public function setAnnee1ereInscriptionUniversite(\DateTimeInterface $annee_1ere_inscription_universite): self
    {
        $this->annee_1ere_inscription_universite = $annee_1ere_inscription_universite;

        return $this;
    }

    public function getAnnee1ereInscriptionEnseignementSuperieur(): ?\DateTimeInterface
    {
        return $this->annee_1ere_inscription_enseignement_superieur;
    }

    public function setAnnee1ereInscriptionEnseignementSuperieur(\DateTimeInterface $annee_1ere_inscription_enseignement_superieur): self
    {
        $this->annee_1ere_inscription_enseignement_superieur = $annee_1ere_inscription_enseignement_superieur;

        return $this;
    }

    public function getAnnee1ereInscriptionUniversiteMarocaine(): ?\DateTimeInterface
    {
        return $this->annee_1ere_inscription_universite_marocaine;
    }

    public function setAnnee1ereInscriptionUniversiteMarocaine(\DateTimeInterface $annee_1ere_inscription_universite_marocaine): self
    {
        $this->annee_1ere_inscription_universite_marocaine = $annee_1ere_inscription_universite_marocaine;

        return $this;
    }

    public function getCodeBac(): ?string
    {
        return $this->code_bac;
    }

    public function setCodeBac(string $code_bac): self
    {
        $this->code_bac = $code_bac;

        return $this;
    }

    public function getSerieBac(): ?string
    {
        return $this->serie_bac;
    }

    public function setSerieBac(string $serie_bac): self
    {
        $this->serie_bac = $serie_bac;

        return $this;
    }

    public function getFiliere(): ?filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }
    public function __toString() {
        return $this->nom;
    }
}
