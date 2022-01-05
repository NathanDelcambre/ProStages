<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function index(): Response
    {
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressources = $repositoryStages->findAll();

        return $this->render('Prostages/prostages.html.twig', [
            'controller_name' => 'to accueil',
            'ressources' => $ressources,
        ]);
    }
}
