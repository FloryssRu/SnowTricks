<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $id;

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
     * @Assert\Lenght(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le titre doit contenir {{ limit }} caractères minimum.",
     *      maxMessage = "Le titre peut contenir {{ limit }} caractères maximum."
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique="true")
     * @Assert\NotBlank(
     *      message = "Le slug ne doit pas être vide."
     * )
     * @Assert\NotNull(
     *      message = "Le slug ne doit pas être null."
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     * @Assert\Lenght(
     *      min = 2,
     *      max = 255
     * )
     */
    private $slug;

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
     * @Assert\Lenght(
     *      min = 2,
     *      minMessage = "La description doit contenir {{ limit }} caractères minimum."
     * )
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="trick", orphanRemoval=true)
     * @Assert\NotBlank(
     *      message = "Vous devez ajouter au moins 1 image."
     * )
     * @Assert\NotNull(
     *      message = "Vous devez ajouter au moins une image."
     * )
     * @Assert\Type("App\Entity\Picture")
     */
    private $picture;

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
     * @Assert\Lenght(
     *      min = 10,
     *      minMessage = "Le texte doit contenir minimum une balise <embed> valide."
     * )
     */
    private $tagsVideo;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="trick", orphanRemoval=true)
     * @Assert\Type("App\Entity\Message")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="trick")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(
     *      message = "Vous devez joindre la figure à un groupe."
     * )
     * @Assert\NotNull(
     *      message = "Le groupe ne doit pas être vide."
     * )
     * @Assert\Type(
     *      type = "string",
     *      message = "La valeur {{ value }} n'est pas un {{ type }} valide."
     * )
     */
    private $relatedGroup;

    public function __construct()
    {
        $this->picture = new ArrayCollection();
        $this->message = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
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
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture[] = $picture;
            $picture->setTrick($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getTrick() === $this) {
                $picture->setTrick(null);
            }
        }

        return $this;
    }

    public function getTagsVideo(): ?string
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
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message[] = $message;
            $message->setTrick($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTrick() === $this) {
                $message->setTrick(null);
            }
        }

        return $this;
    }

    public function getRelatedGroup(): ?Group
    {
        return $this->relatedGroup;
    }

    public function setRelatedGroup(?Group $relatedGroup): self
    {
        $this->relatedGroup = $relatedGroup;

        return $this;
    }
}
