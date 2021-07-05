<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Stmt\Foreach_;

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    

    /**
     * @ORM\OneToMany(targetEntity=Pokemon::class, mappedBy="team", orphanRemoval=true, cascade={"persist"})
     */
    private $pokemon_list;

    public function __construct()
    {
        $this->pokemon_list = new ArrayCollection();
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
     * @return Collection|Pokemon[]
     */
    public function getPokemonList(): Collection
    {
        return $this->pokemon_list;
    }

    public function pokemon_list(): Collection
    {
        return $this->pokemon_list;
    }

    public function addPokemon(Pokemon $pokemon): self
    {
        if (!$this->pokemon_list->contains($pokemon)) {
            $this->pokemon_list[] = $pokemon;
            $pokemon->setTeam($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): self
    {
        if ($this->pokemon_list->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getTeam() === $this) {
                $pokemon->setTeam(null);
            }
        }

        return $this;
    }
    
    public function sum_experiences() 
    {
        $sum_exps = 0;
        foreach ($this->pokemon_list as $pokemon) {
            $sum_exps+= $pokemon->base_experience();
        }
        
        return $sum_exps;
    }

    public function types():string
    {
        $types = "";
        foreach ($this->pokemon_list as $pokemon) {
            foreach ($pokemon->type_list() as $type) {
                if($types == null) {
                    $types = $type->getName();
                }
                else {
                    if(strpos($types, $type->getName()) === false) {
                        $types = $types."|".$type->getName();
                    }
                }
            }
            
        }
        
        return $types;
    }
}
