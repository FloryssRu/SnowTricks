<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
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
     *      message = "La date ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "La date ne doit pas être null."
     * )
     * @Assert\DateTime(
     *      message = "La date doit être sous forme datetime."
     * )
     * @Assert\Type(
     *     type = "datetime",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private string $dateCreation;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message = "Le contenu ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "Le contenu ne doit pas être null."
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Le contenu doit avoir au moins {{ limit }} caractères.",
     * )
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="message")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Le message doit être relié à un trick."
     * )
     * @Assert\NotNull(
     *      message = "Le message doit être relié à un trick."
     * )
     * @Assert\Type("App\Entity\Trick")
     */
    private Trick $trick;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="message")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Le message doit être relié à un utilisateur."
     * )
     * @Assert\NotNull(
     *      message = "Le message doit être relié à un utilisateur."
     * )
     * @Assert\Type("App\Entity\User")
     */
    private User $user;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?string
    {
        return $this->dateCreation;
    }

    public function setDateCreation(string $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
