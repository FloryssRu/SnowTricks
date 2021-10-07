<?php

namespace App\Entity;

use App\Entity\Trick;
use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @UniqueEntity(
 *      fields = {"name", "trick"},
 *      message = "Afin d'éviter une erreur d'affichage, veuillez renommer l'image."
 * )
 */
class Picture
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
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "L'image doit être reliée à un trick."
     * )
     * @Assert\NotNull(
     *      message = "L'image doit être reliée à un trick."
     * )
     * @Assert\Type("App\Entity\Trick")
     */
    private Trick $trick;

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

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
