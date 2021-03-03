<?php

namespace App\Entity;

use App\Repository\LimiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LimiteRepository::class)
 * @ORM\Table(name="`limite`")
 */
class Limite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $att_scolarite;

    /**
     * @ORM\Column(type="smallint")
     */
    private $conv_stage;

    /**
     * @ORM\Column(type="smallint")
     */
    private $rel_note;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttScolarite(): ?int
    {
        return $this->att_scolarite;
    }

    public function setAttScolarite(int $att_scolarite): self
    {
        $this->att_scolarite = $att_scolarite;

        return $this;
    }

    public function getConvStage(): ?int
    {
        return $this->conv_stage;
    }

    public function setconvStage(int $conv_stage): self
    {
        $this->conv_stage = $conv_stage;

        return $this;
    }

    public function getRelNote(): ?int
    {
        return $this->rel_note;
    }

    public function setRelNote(int $rel_note): self
    {
        $this->rel_note = $rel_note;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
