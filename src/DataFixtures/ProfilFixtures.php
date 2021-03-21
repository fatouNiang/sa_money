<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Profil;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public static function getReferenceKey($i){
        return sprintf('profil_user_%s',$i);
    }
 
    public function load(ObjectManager $manager)
    {
        $libelles=['ADMINSYSTEM',"AGENCE","CAISSIER","ADMIN_AGENCE"];

            for ($i=0;$i<=3;$i++){
                $profil=new Profil();
                $profil->setLibelle($libelles[$i]);
                    //->setArchivage(false);
                $manager->persist($profil);
                $this->addReference(self::getReferenceKey($i),$profil);

            }
            $manager->flush();

    }
}
