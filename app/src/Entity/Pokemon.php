<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $base_experience;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="pokemon_list", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity=Ability::class, mappedBy="pokemon", orphanRemoval=true, cascade={"persist"})
     */
    private $ability_list;

    /**
     * @ORM\OneToMany(targetEntity=Type::class, mappedBy="pokemon", orphanRemoval=true, cascade={"persist"})
     */
    private $type_list;

    public function __construct()
    {
        $this->ability_list = new ArrayCollection();
        $this->type_list = new ArrayCollection();
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

    public function base_experience(): ?int
    {
        return $this->base_experience;
    }

    public function setBaseExperience(int $base_experience): self
    {
        $this->base_experience = $base_experience;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection|Ability[]
     */
    public function ability_list(): Collection
    {
        return $this->ability_list;
    }

    public function addAbility(Ability $ability): self
    {
        if (!$this->ability_list->contains($ability)) {
            $this->ability_list[] = $ability;
            $ability->setPokemon($this);
        }

        return $this;
    }

    public function removeAbility(Ability $ability): self
    {
        if ($this->ability_list->removeElement($ability)) {
            // set the owning side to null (unless already changed)
            if ($ability->getPokemon() === $this) {
                $ability->setPokemon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function type_list(): Collection
    {
        return $this->type_list;
    }

    public function addType(Type $type): self
    {
        if (!$this->type_list->contains($type)) {
            $this->type_list[] = $type;
            $type->setPokemon($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->type_list->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getPokemon() === $this) {
                $type->setPokemon(null);
            }
        }

        return $this;
    }
    
    
    public function __toString()
    {
        return $this->getName();
    }
    
}
