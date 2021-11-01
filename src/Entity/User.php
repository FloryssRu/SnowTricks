<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *      fields = "email",
 *      message = "Adresse email déjà utilisée."
 * )
 * @UniqueEntity(
 *      fields = "username",
 *      message = "Nom d'utilisateur déjà utilisé."
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *      message = "Le nom d'utilisateur ne doit pas être vide.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\NotNull(
     *      message = "Le nom d'utilisateur ne doit pas être null.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 180,
     *      minMessage = "Votre nom dit contenir au moins {{ limit }} caractères.",
     *      maxMessage = "Votre nom peut contenir au maximum {{ limit }} caractères."
     * )
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255, unique="true")
     * @Assert\NotBlank(
     *      message = "L'email ne doit pas être vide.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\NotNull(
     *      message = "L'email ne doit pas être null.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\Type(
     *      type = "string",
     *      message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Email(
     *      message = "Veuillez entrer une adresse email valide."
     * )
     */
    private string $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *      message = "Le mot de passe ne doit pas être vide.",
     *      groups = {"not-in-registration-form", "not-in-account-form"}
     * )
     * @Assert\NotNull(
     *      message = "Le mot de passe ne doit pas être null.",
     *      groups = {"not-in-registration-form", "not-in-account-form"}
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 4096,
     *      minMessage = "Votre mot de passe doit contenir {{ limit }} caractères minimum.",
     * )
     */
    private string $password;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(
     *      message = "Les rôles ne peuvent pas être null.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\Type(
     *     type = "array",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(
     *      message = "La vérification de compte ne peut pas être null.",
     *      groups = "not-in-account-form"
     * )
     * @Assert\Type(
     *     type = "boolean",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private bool $isVerified;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user")
     */
    private Collection $messages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(
     *      type = "string",
     *      message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private ?string $pictureName;

    public function __construct()
    {
        $this->message = new ArrayCollection();
        $this->isVerified = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

     /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(?string $pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }
}
