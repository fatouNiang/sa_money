<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
 
    private $encode;
    protected $profilRepositiry;
    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode=$encode;
    }

    
    public function load(ObjectManager $manager)

    {
        $fake = Factory::create('fr-FR');
            for($i=0;$i<=3;$i++){

                $nbrUser=1;
                $userProfil=$this->getReference(ProfilFixtures::getReferenceKey($i %4));

                for ($b=1;$b<=$nbrUser;$b++){

                    $user=new User();

                    if($userProfil->getLibelle()==="ADMINSYSTEM"){

                        $user=new User();
                                           }
                    if($userProfil->getLibelle()==="AGENCE"){
                        $user=new User();
                    }
                    if($userProfil->getLibelle()==="CAISSIER"){
                        $user=new User();
                    }

                if($userProfil->getLibelle()==="ADMIN_AGENCE"){

                    $user=new User();

                }
                    $user->setProfil($userProfil)
                        //->setUsername( strtolower ($fake->userName))
                        ->setEmail($fake->email)
                        ->setFirstname($fake->firstName)
                        ->setLastname($fake->lastName)
                        ->setTelephone(779184216)
                        ->setBloque(false);
                    //$photo = fopen($fake->imageUrl($width = 640, $height = 480),"rb");
                    $user->setAvatar("avatar");
                    $password = $this->encode->encodePassword ($user, 'secret' );
                    $user->setPassword($password);
                    
                    $manager->persist($user);
                }
            }
            $manager->flush();

    }
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
    }

}