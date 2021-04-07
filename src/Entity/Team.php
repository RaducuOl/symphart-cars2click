<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="teams")
     */
    private $game;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $score;

    
    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->game->removeElement($game);

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    // public function getScoreFromTable(): ?Score
    // {
    //     return $this->score_from_table;
    // }

    // public function setScoreFromTable(Score $score_from_table): self
    // {
    //     // set the owning side of the relation if necessary
    //     if ($score_from_table->getTeam() !== $this) {
    //         $score_from_table->setTeam($this);
    //     }

    //     $this->score_from_table = $score_from_table;

    //     return $this;
    // }
}
