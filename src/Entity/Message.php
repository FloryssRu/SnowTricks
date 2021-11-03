<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTimeInterface;
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
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(
     *      message = "La date ne doit pas être vide.",
     *      groups = "not-in-message-form"
     * )
     * @Assert\NotNull(
     *      message = "La date ne doit pas être null."
     * )
     */
    private $createdAt;

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
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Le message doit être relié à un trick.",
     *      groups = "not-in-message-form"
     * )
     * @Assert\NotNull(
     *      message = "Le message doit être relié à un trick.",
     *      groups = "not-in-message-form"
     * )
     * @Assert\Type("App\Entity\Trick")
     */
    private Trick $trick;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Le message doit être relié à un utilisateur.",
     *      groups = "not-in-message-form"
     * )
     * @Assert\NotNull(
     *      message = "Le message doit être relié à un utilisateur.",
     *      groups = "not-in-message-form"
     * )
     * @Assert\Type("App\Entity\User")
     */
    private User $user;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function setTrick(Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
