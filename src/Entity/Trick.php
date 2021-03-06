<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use App\Entity\Picture;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @UniqueEntity(
 *      fields = "name",
 *      message = "Nom de figure déjà utilisé."
 * )
 * @UniqueEntity(
 *      fields = "slug",
 *      message = "Le slug généré est déjà attribué. Changez le nom de figure."
 * )
 */
class Trick
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
     * @ORM\Column(type="string", length=255, unique="true")
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
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le titre doit contenir {{ limit }} caractères minimum.",
     *      maxMessage = "Le titre peut contenir {{ limit }} caractères maximum."
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique="true")
     * @Assert\NotBlank(
     *      message = "Le slug ne doit pas être vide.",
     *      groups = "not-in-create-form"
     * )
     * @Assert\NotNull(
     *      message = "Le slug ne doit pas être null.",
     *      groups = "not-in-create-form"
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 255
     * )
     */
    private string $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message = "La description ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "La description ne doit pas être null."
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "La description doit contenir {{ limit }} caractères minimum."
     * )
     */
    private string $description;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="trick", cascade={"persist"}, orphanRemoval=true)
     * @Assert\NotBlank(
     *      message = "Vous devez ajouter au moins 1 image."
     * )
     * @Assert\NotNull(
     *      message = "Vous devez ajouter au moins une image."
     * )
     */
    private Collection $pictures;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message = "Vous devez ajouter au moins 1 vidéo."
     * )
     * @Assert\NotNull(
     *      message = "Vous devez ajouter au moins 1 vidéo."
     * )
     * @Assert\Type(
     *      type = "string",
     *      message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit contenir minimum une balise <embed> valide."
     * )
     */
    private string $tagsVideo;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="trick", orphanRemoval=true)
     */
    private Collection $messages;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="trick", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Vous devez joindre la figure à un groupe."
     * )
     * @Assert\NotNull(
     *      message = "Le groupe ne doit pas être vide."
     * )
     * @Assert\Type(
     *      type = "object",
     *      message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private Group $relatedGroup;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(
     *      message = "La date de création ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "La date de création ne doit pas être null."
     * )
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt;

    public function __construct()
    {
        $this->message = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->createdAt = new \DateTime();
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setTrick($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            if ($picture->getTrick() === $this) {
                $this->pictures->removeElement($picture);
            }
        }

        return $this;
    }

    public function removeAllPictures(): self
    {
        $this->pictures->clear();
        return $this;
    }

    public function getTagsVideo(): string
    {
        return $this->tagsVideo;
    }

    public function setTagsVideo(string $tagsVideo): self
    {
        $this->tagsVideo = $tagsVideo;

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
            $message->setTrick($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getTrick() === $this) {
                $message->setTrick(null);
            }
        }

        return $this;
    }

    public function getRelatedGroup(): Group
    {
        return $this->relatedGroup;
    }

    public function setRelatedGroup(Group $relatedGroup): self
    {
        $this->relatedGroup = $relatedGroup;

        return $this;
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

    public function getModifiedAt(): ?DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
