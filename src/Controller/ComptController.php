<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptController extends AbstractController
{
    /**
     * @Route("/compt", name="getSold")
     */
    public function index(): Response
    {
        return $this->render('compt/index.html.twig', [
            'controller_name' => 'ComptController',
        ]);
    }

}
