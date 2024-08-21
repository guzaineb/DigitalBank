<?php

namespace App\Controller;

use App\Entity\CompteBancaire;
use App\Form\CompteBancaireType;
use App\Repository\CompteBancaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte/bancaire')]
class CompteBancaireController extends AbstractController
{
    #[Route('/', name: 'app_compte_bancaire_index', methods: ['GET'])]
    public function index(CompteBancaireRepository $compteBancaireRepository): Response
    {
        return $this->render('compte_bancaire/index.html.twig', [
            'compte_bancaires' => $compteBancaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_compte_bancaire_new', methods: ['GET', 'POST'])]
    #[Route('/new', name: 'app_compte_bancaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compteBancaire = new CompteBancaire();
        $form = $this->createForm(CompteBancaireType::class, $compteBancaire);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérez le dernier numéro de compte
            $lastAccount = $entityManager->getRepository(CompteBancaire::class)
                ->findOneBy([], ['numero_compte' => 'DESC']);
            
            $newAccountNumber = $lastAccount ? $lastAccount->getNumeroCompte() + 1 : 1000000;
    
            // Définissez le nouveau numéro de compte
            $compteBancaire->setNumeroCompte($newAccountNumber);
    
            // Persist et flush
            $entityManager->persist($compteBancaire);
            $entityManager->flush();
    
            // Redirection après succès
            return $this->redirectToRoute('app_compte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('compte_bancaire/new.html.twig', [
            'compte_bancaire' => $compteBancaire,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_compte_bancaire_show', methods: ['GET'])]
    public function show(CompteBancaire $compteBancaire): Response
    {
        return $this->render('compte_bancaire/show.html.twig', [
            'compte_bancaire' => $compteBancaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_compte_bancaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompteBancaire $compteBancaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteBancaireType::class, $compteBancaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_bancaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_bancaire/edit.html.twig', [
            'compte_bancaire' => $compteBancaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_compte_bancaire_delete', methods: ['POST'])]
    public function delete(Request $request, CompteBancaire $compteBancaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compteBancaire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($compteBancaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_bancaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
