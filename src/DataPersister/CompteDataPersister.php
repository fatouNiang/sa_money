<?php

namespace App\DataPersister;

use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * 
 */

class CompteDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

     /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Compte;
    }


    public function persist($data, array $context = [])
    {
        $data->genererNumCompte();
        $users=  $data->getAgence()->getUser();

       foreach ($users as $user) {
            $pwd= $this->_passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($pwd);
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);
        $data->getAgence()->setArchivage(true);
        $users=  $data->getAgence()->getUser();

        foreach ($users as $user) {
            $user->setBloque(true);
        }
        $this->_entityManager->flush();
    }
}