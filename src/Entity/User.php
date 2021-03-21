<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
 

/**
 * @ApiResource(routePrefix="/admin",
 *       collectionOperations={"get",
 *               "add_users"={ 
 *               "method"="POST", 
 *               "path"="/users",
 *          },
 * },
 *       itemOperations={"get",
 *          "getUsersByidProfil"={
 *              "method"="get",
 *              "path" ="/users/{id}/profil"
 *      },
 *        "put_users"={ 
 *               "method"="PUT", 
 *               "path"="/users/{id}",
 *          },
 *      "userbloque"={
 *          "method"="DELETE", 
 *          "path"="/users/{id}",
 *      }
 *  },
 * 
 *      normalizationContext={"groups"={"user:read"}, "enable_max_depth"=true},
 *      denormalizationContext={"groups"={"user:write"}, "enable_max_depth"=true},
*       attributes = {"security"="is_granted('ROLE_ADMINSYSTEM')" ,
 *              "security_message"="Acces non autorisé"})
 *
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"bloque"})

 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     * @Groups({"compte:write", "compte:read", "transaction:write"})
     */
    private $email;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("user:write")
     * @Groups({"compte:write", "compte:read", "transaction:write"})
     */
    private $password= "secret";

    /**
     * @SerializedName("password")
     * @Groups("user:write")
     * @Groups({"compte:write", "compte:read", "transaction:write"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     * @Groups({"compte:write", "compte:read"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"user:read", "user:write"})
     * @Groups({"compte:write", "compte:read", "transaction:write"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string")
     * @Groups({"user:read", "user:write"})
     * @Assert\NotBlank
     * @Groups({"compte:write", "transaction:write"})
     */
    private $telephone;

 
    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users", cascade={"persist", "remove"})
     * @MaxDepth(7)
     * @Groups({"compte:write", "compte:read", "transaction:write"})
     * @Groups({"profil:read", "profil:write", "user:write"})
     */
    private $profil;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @Groups({"compte:write", "compte:read", "transaction:write"})

     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bloque=0;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="user")
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="userDepot")
     */
    private $transactions;

    public function __construct()
    {
        $this->agences = new ArrayCollection();
        $this->compte = new ArrayCollection();
        $this->transaction = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
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
         $this->plainPassword = null;
    }

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

     
    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
    
    public function getAvatar()
    {
        //return $this->avatar;
        if($this->avatar){
            $avatar=stream_get_contents($this->avatar);
            if(!$this->avatar){
                @fclose($this->avatar);

            }
            return base64_encode($avatar);
        }else{
            return null;
        }
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setUserDepot($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUserDepot() === $this) {
                $transaction->setUserDepot(null);
            }
        }

        return $this;
    }
}
