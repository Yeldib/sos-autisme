<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\ProUserRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProUserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Cette adresse email est déjà utilisée"
 * )
 */
class ProUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
  
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir renseigner votre prénom")
     * @Assert\Length(max=50, maxMessage="Ce champ ne peut pas contenir plus de 50 caractères ")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir renseigner votre nom")
     * @Assert\Length(max=50, maxMessage="Ce champ ne peut pas contenir plus de 50 caractères ")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="L'adresse email est invalide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Vos mots de passe ne sont pas identiques")
     */
    public $passwordConfirm;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $jobCategory;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $department;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(max=255, maxMessage="La déscription ne doit pas contenir plus de 255 caractères.")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companySiret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="L'URL est invalide. voici un exemple d'URL valide : https://maphoto/64x64")
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="proUsers")
     */
    private $proUserRoles;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="proUser", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->proUserRoles = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getFullName()
    {
        return "{$this->lastName} {$this->firstName}";
    }

    /**
     * Permet d'initialiser le slug
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->firstName .' '. $this->lastName);
        }
    }

    /**
     * Permet de calculer la moyenne globale d'un utilisateur pro
     *
     * @return float
     */
    public function getAvgRatings()
    {
        // On calcul la somme des notes
        $sum = array_reduce($this->comments->toArray(), function($total, $comment) {
            return $total + $comment->getRating();
        }, 0);

        // Division pour avoir la moyenne
        if(count($this->comments) > 0) return $sum / count($this->comments);

        return 0;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getJobCategory(): ?string
    {
        return $this->jobCategory;
    }

    public function setJobCategory(string $jobCategory): self
    {
        $this->jobCategory = $jobCategory;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->userRoles->map(function($role){
           return $role->getTitle(); 
        })->toArray();

        $roles[] = 'ROLE_PRO_USER';
     
        return $roles;
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getSalt()
    {
        # code...
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        # code...
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }


    public function getCompanySiret(): ?string
    {
        return $this->companySiret;
    }

    public function setCompanySiret(string $companySiret): self
    {
        $this->companySiret = $companySiret;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getProUserRoles(): Collection
    {
        return $this->proUserRoles;
    }

    public function addProUserRole(Role $proUserRole): self
    {
        if (!$this->proUserRoles->contains($proUserRole)) {
            $this->proUserRoles[] = $proUserRole;
            $proUserRole->addProUser($this);
        }

        return $this;
    }

    public function removeProUserRole(Role $proUserRole): self
    {
        if ($this->proUserRoles->contains($proUserRole)) {
            $this->proUserRoles->removeElement($proUserRole);
            $proUserRole->removeProUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProUser() === $this) {
                $comment->setProUser(null);
            }
        }

        return $this;
    }
}
