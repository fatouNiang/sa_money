<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptController extends AbstractController
{
    // /**
    //  * @Route("/api/comptes/curentUser", name="getSolde", methods={"GET"})
    //  */
    // public function getSolde(): Response
    // {
    //     $userConnect= $this->getUser();
    //     //dd($userConnect);
    //      $compt= $userConnect->getAgence();
    //      //dd($compt);
    //     $compt= $userConnect->getAgence()->getCompte();
    //     dd($compt);
    //     return $this->json($userConnect, 200, [], ["groups"=>["getSolde"]] );
    //    // return $this->json($userConnect,200  );

    // }

}
