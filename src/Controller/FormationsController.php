<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="formations")
     */
    public function index($id): Response
    {
        return $this->render('formations/formations.html.twig', [
            'controller_name' => 'FormationsController',
            'id' => $id,
        ]);
    }
}
