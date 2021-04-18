<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 *  *
* @ApiResource(
 *       normalizationContext={"groups"={"pokemon"}},
 *       paginationEnabled=false
 * )
 * 
 */
class Pokemon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"pokemon", "generation", "type"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon", "generation", "type"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"pokemon", "generation", "type"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="pokemon")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $type1;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class)
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $type2;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $vie;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $attaque;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $defense;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $legendaire;

    /**
     * @ORM\ManyToOne(targetEntity=Generation::class, inversedBy="pokemon")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pokemon"})
     */
    #[Groups(['pokemon:list', 'pokemon:item'])]
    private $generation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

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

    public function getType1(): ?Type
    {
        return $this->type1;
    }

    public function setType1(?Type $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?Type
    {
        return $this->type2;
    }

    public function setType2(?Type $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getVie(): ?int
    {
        return $this->vie;
    }

    public function setVie(int $vie): self
    {
        $this->vie = $vie;

        return $this;
    }

    public function getAttaque(): ?int
    {
        return $this->attaque;
    }

    public function setAttaque(int $attaque): self
    {
        $this->attaque = $attaque;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getLegendaire(): ?bool
    {
        return $this->legendaire;
    }

    public function setLegendaire(bool $legendaire): self
    {
        $this->legendaire = $legendaire;

        return $this;
    }

    public function getGeneration(): ?Generation
    {
        return $this->generation;
    }

    public function setGeneration(?Generation $generation): self
    {
        $this->generation = $generation;

        return $this;
    }
}
