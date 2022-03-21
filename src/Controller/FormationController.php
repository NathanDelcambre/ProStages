<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Form\FormationType;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/voir/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $uneFormation, EntityManagerInterface $manager): Response
    {
        $formulaireFormation = $this->createForm(FormationType::class, $uneFormation);
        $formulaireFormation->handleRequest($request);

        if ($formulaireFormation->isSubmitted() && $formulaireFormation->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/ajouterModifierFormation.html.twig', [
            'vueFormulaireFormation' => $formulaireFormation -> createView(),
            'action' => "modifier",
            'formation' => $uneFormation,
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/ajouter_formation", name="AjoutFormation")
     */
    public function ajoutFormation(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Création d'une formation initialement vierge
        $formation = new Formation();

        // création d'un objet formulaire pour ajouter une formation
        $formulaireFormation=$this->createForm(FormationType::class, $formation);

            $formulaireFormation->handleRequest($requeteHttp);

            if($formulaireFormation->isSubmitted() && $formulaireFormation->isValid())
            {
                // Enregistrer la ressource en BD
                $manager->persist($formation);
                $manager->flush();
                // Rediriger l’utilisateur
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('formation/ajouterModifierFormation.html.twig', ['vueFormulaireFormation' => $formulaireFormation -> createView(), 'action' => "ajouter",'formation' => $formation]);
    }
}
