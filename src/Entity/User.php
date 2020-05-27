<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields={"email"}, 
 *  message="Il y à déjà un utilisateur avec cet email"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="l'email est obligatoire")
     * @Assert\Email(message="l'email n'est pas au bon format ex : xxx@xxx.xxx")
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, inversedBy="users")
     */
    private $favBook;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le password est obligatoire")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Votre mdp doit être le même")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mdp doit être le même")
     */
    public $confirm_password;

    public function __construct()
    {
        $this->favBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getFavBook(): Collection
    {
        return $this->favBook;
    }

    public function addFavBook(Book $favBook): self
    {
        if (!$this->favBook->contains($favBook)) {
            $this->favBook[] = $favBook;
        }

        return $this;
    }

    public function removeFavBook(Book $favBook): self
    {
        if ($this->favBook->contains($favBook)) {
            $this->favBook->removeElement($favBook);
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

}
