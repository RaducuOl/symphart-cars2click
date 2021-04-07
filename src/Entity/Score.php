<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScoreRepository::class)
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $location;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="scores")
    //  * @ORM\JoinColumn(nullable=false)
    //  */

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="scores")
     */
    private $game;

    /**
     * @ORM\OneToOne(targetEntity=Team::class, inversedBy="score", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    // public function getGame(): ?Game
    // {
    //     return $this->game;
    // }

    // public function setGame(?Game $game): self
    // {
    //     $this->game = $game;

    //     return $this;
    // }

    // public function getTeam(): ?Team
    // {
    //     return $this->team;
    // }

    /**
     * @return Collection|Score[]
     */
    public function getScore(): Collection
    {
        return $this->score;
    }

    public function addScore(Score $score): self
    {
        if (!$this->score->contains($score)) {
            $this->score[] = $score;
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        $this->score->removeElement($score);

        return $this;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

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
}
