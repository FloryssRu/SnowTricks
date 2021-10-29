<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\Type(
     *     type = "integer",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Le nom ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "Le nom ne doit pas être null."
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Trick::class, mappedBy="relatedGroup")
     */
    private Collection $trick;

    public function __construct()
    {
        $this->trick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTrick(): Collection
    {
        return $this->trick;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->trick->contains($trick)) {
            $this->trick[] = $trick;
            $trick->setRelatedGroup($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->trick->removeElement($trick)) {
            if ($trick->getRelatedGroup() === $this) {
                // do something
            }
        }

        return $this;
    }
}
