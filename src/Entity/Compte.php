<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  collectionOperations={
 *      "get"={"access_control"= "is_granted('ROLE_ADMINSYSTEM')"},
 *      "post"={"access_control"= "is_granted('ROLE_ADMINSYSTEM')"}
 * },
 *  itemOperations={
 *      "get"={"access_control"= "is_granted('ROLE_ADMINSYSTEM')"},
 *      "delete"={"access_control"= "is_granted('ROLE_ADMINSYSTEM')"}
 * },
 *    normalizationContext={"groups"={"compte:read"}},
 *    denormalizationContext={"groups"={"compte:write"}},
 * )
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte:write" , "compte:read"})
     */
    private $numCompte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte:write", "compte:read"})
     */
    private $montant=700000.00;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte:write", "compte:read"})
     */
    private $archivage=false;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="compte", cascade={"persist", "remove"})
     * @Groups({"compte:write", "compte:read"})
     */
    private $agence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte): self
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): self
    {
        // set the owning side of the relation if necessary
        if ($agence->getCompte() !== $this) {
            $agence->setCompte($this);
        }

        $this->agence = $agence;

        return $this;
    }

    public function genererNumCompte($nom=12){
        $num=intval(uniqid(rand(100,999)));
        $cc=substr( $nom, 0,2);
        $data= date('Y').strtoupper($cc).$num.rand(0,9);
        $this->numCompte= $data;
    }
    
        
}
