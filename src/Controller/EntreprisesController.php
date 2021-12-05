<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="entreprises")
     */
    public function index($id): Response
    {
        return $this->render('entreprises/entreprises.html.twig', [
            'controller_name' => 'EntreprisesController',
            'id' => $id,
        ]);
    }
}
