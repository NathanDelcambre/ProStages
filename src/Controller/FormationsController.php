<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="Formations")
     */
    public function index($id): Response
    {

        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
        $ressources = $repositoryFormation->findAll();

        return $this->render('formations/formations.html.twig', [
            'controller_name' => 'FormationsController',
            'id' => $id,
            'ressources' => $ressources,
        ]);
    }
}
