<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

class StagesController extends AbstractController
{
    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function index($id): Response
    {
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressourceStage = $repositoryStages->find($id);
        $lesFormations = $ressourceStage->getFormation();

        return $this->render('stages/stages.html.twig', [
            'controller_name' => 'StagesController',
            'ressourceStage' => $ressourceStage,
            'lesFormations' => $lesFormations,
        ]);
    }
}
