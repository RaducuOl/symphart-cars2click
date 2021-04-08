<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $date;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $stage;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $week;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    // /**
    //  * @ORM\ManyToMany(targetEntity=Team::class, mappedBy="game")
    //  * @ORM\JoinTable(name="team_game")
    //  */

     /**
      * @ORM\ManyToMany(targetEntity="Team")
      * @ORM\JoinTable(name="game_team",
      * joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")},
      * inverseJoinColumns={@ORM\JoinColumn(name="team_id",referencedColumnName="id")})
      */
    private $teams;

    // /**
    //  * @ORM\OneToMany(targetEntity=Score::class, mappedBy="game", orphanRemoval=true)
    //  */

    /**
     * @ORM\OneToMany(targetEntity=Score::class, mappedBy="game")
     */
    private $score;
    /**
     * @ORM\ManyToOne(targetEntity=League::class, inversedBy="game")
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="game")
     */
    private $country;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->score = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getStage(): ?string
    {
        return $this->stage;
    }

    public function setStage(?string $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getWeek(): ?string
    {
        return $this->week;
    }

    public function setWeek(?string $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    
    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addGame($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            $team->removeGame($this);
        }

        return $this;
    }

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
            $score->setGame($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->score->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getGame() === $this) {
                $score->setGame(null);
            }
        }

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }



    // o tara are mai multe jocuri
    //country = game
    //game = score
}
