<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(denormalizationContext={"groups"={"transaction:write"}})
 * 
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction:write"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"transaction:write"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:write"})
     */
    private $frais;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:write"})
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:write"})
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:write"})
     */
    private $fraisSystem;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:write"})
     */
    private $fraisEtat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:write"})
     */
    private $userDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions", cascade={"persist", "remove"})
     * @Groups({"transaction:write"})
     */
    private $UserRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transactions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:write"})
     */
    private $clientDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="transactions", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:write"})
     */
    private $clientRetrait;

    /**
     * @Groups({"transaction:write"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateAnnulation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:write"})
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisDepot(): ?float
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(float $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?float
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(float $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisSystem(): ?float
    {
        return $this->fraisSystem;
    }

    public function setFraisSystem(float $fraisSystem): self
    {
        $this->fraisSystem = $fraisSystem;

        return $this;
    }

    public function getFraisEtat(): ?float
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(float $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

    public function getUserRetrait(): ?User
    {
        return $this->UserRetrait;
    }

    public function setUserRetrait(?User $UserRetrait): self
    {
        $this->UserRetrait = $UserRetrait;

        return $this;
    }

    public function getClientDepot(): ?Client
    {
        return $this->clientDepot;
    }

    public function setClientDepot(?Client $clientDepot): self
    {
        $this->clientDepot = $clientDepot;

        return $this;
    }

    public function getClientRetrait(): ?Client
    {
        return $this->clientRetrait;
    }

    public function setClientRetrait(?Client $clientRetrait): self
    {
        $this->clientRetrait = $clientRetrait;

        return $this;
    }


    public function getDateAnnulation(): ?\DateTimeInterface
    {
        return $this->dateAnnulation;
    }

    public function setDateAnnulation(?\DateTimeInterface $dateAnnulation): self
    {
        $this->dateAnnulation = $dateAnnulation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    
    public function calculFrais($pourcentage){
        return ($pourcentage * $this->frais )/100;
    }

    public function initialise($user_depot){

        $this->calculFraisTotal();
        $this->fraisEtat= $this->calculFrais(40);
        $this->fraisSystem = $this->calculFrais(30);
        $this->fraisDepot = $this->calculFrais(10);
        $this->fraisRetrait = $this->calculFrais(20);
        //$this->genererCode();
        $this->dateDepot= new DateTime();
        $this->userDepot= $user_depot;
    }

    // public function genererCode($longueur=6){
    //     $char= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $longueurMax= strlen($char);
    //     $chaineAleatoire='';
    //     for ($i=0; $i < $longueur; $i++) { 
    //         $chaineAleatoire= $char[rand(0, $longueurMax-1)];
    //     }    
    //     $this->code= $chaineAleatoire;
    // }

    public function calculFraisTotal(){
        switch (true) {
            case ($this->montant<=5000):
                $this->frais= 425;
                break;
            case ($this->montant<=10000 && $this->montant > 5000):
                $this->frais= 850;
                break;
            case ($this->montant<=15000 && $this->montant > 10000):
                $this->frais= 1270;
                break;
            case ($this->montant<=20000 && $this->montant > 15000):
                $this->frais= 1695;
                break;

            case ($this->montant<=50000 && $this->montant > 20000):
                $this->frais= 2500;
                break;

            case ($this->montant<=60000 && $this->montant > 50000):
                $this->frais= 3000;
                break;
            case ($this->montant<=75000 && $this->montant > 60000):
                $this->frais= 4000;
                break;
            case ($this->montant<=120000 && $this->montant > 75000):
                $this->frais= 5000;
                break;
            case ($this->montant<=150000 && $this->montant > 120000):
                $this->frais= 6000;
                break;
            case ($this->montant<=200000 && $this->montant > 150000):
                $this->frais= 7000;
                break;
            case ($this->montant<=250000 && $this->montant > 200000):
                    $this->frais= 8000;
                break;
            case ($this->montant<=300000 && $this->montant > 250000):
                $this->frais= 9000;
                break;
            case ($this->montant<=400000 && $this->montant > 300000):
                $this->frais= 12000;
                break;
            case ($this->montant<=750000 && $this->montant > 400000):
                $this->frais= 15000;
                break;
            case ($this->montant<=900000 && $this->montant > 750000):
                $this->frais= 22000;
                break;
            case ($this->montant<=1000000 && $this->montant > 900000):
                $this->frais= 25000;
                break;
             case ($this->montant<=1125000 && $this->montant > 1000000):
                $this->frais= 27000;
                break;
             case ($this->montant<=1400000 && $this->montant > 1125000):
                $this->frais= 30000;
                break;
             case ($this->montant<=2000000 && $this->montant > 1400000):
                $this->frais= 30000;
                break;
            case ($this->montant > 2000000):
                $this->frais=(2 * $this->montant)/100;
                break;

            default:
                error();
                break;
        }
    }


 
}