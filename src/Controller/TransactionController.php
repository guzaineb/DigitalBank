<?php

namespace App\Controller;

use App\Entity\CompteBancaire;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_transaction_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }
    

   

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification personnalisée
            if ($transaction->getIdDonneur() === $transaction->getIdRecepteur()) {
                $this->addFlash('error', 'Le récepteur ne peut pas être le donneur.');
                return $this->render('transaction/new.html.twig', [
                    'transaction' => $transaction,
                    'form' => $form,
                ]);
            }
    
            // Récupération des comptes bancaires associés
            $compteDonneur = $entityManager->getRepository(CompteBancaire::class)->find($transaction->getIdDonneur());
            $compteRecepteur = $entityManager->getRepository(CompteBancaire::class)->find($transaction->getIdRecepteur());
    
            if (!$compteDonneur || !$compteRecepteur) {
                $this->addFlash('error', 'Compte donneur ou récepteur non trouvé.');
                return $this->render('transaction/new.html.twig', [
                    'transaction' => $transaction,
                    'form' => $form,
                ]);
            }
    
            // Vérification du solde disponible
            $soldeDonneur = $compteDonneur->getSolde();
            $soldeRecepteur = $compteRecepteur->getSolde();
    
            if ($soldeDonneur === null || $soldeRecepteur === null) {
                $this->addFlash('error', 'Solde du compte donneur ou récepteur non initialisé.');
                return $this->render('transaction/new.html.twig', [
                    'transaction' => $transaction,
                    'form' => $form,
                ]);
            }
    
            // Convertir les montants en float pour les calculs
            $montantTransaction = (float)$transaction->getMontant();
            $montantDonneur = (float)$soldeDonneur->getMontant();
    
            if ($montantDonneur < $montantTransaction) {
                $this->addFlash('error', 'Solde insuffisant pour effectuer cette transaction.');
                return $this->render('transaction/new.html.twig', [
                    'transaction' => $transaction,
                    'form' => $form,
                ]);
            }
    
            // Mise à jour des soldes
            $soldeDonneur->setMontant((string)($montantDonneur - $montantTransaction));
            $soldeRecepteurMontant = (float)$soldeRecepteur->getMontant();
            $soldeRecepteur->setMontant((string)($soldeRecepteurMontant + $montantTransaction));
    
            // Générer automatiquement la référence
            $transaction->setReference(uniqid('trans_', true));
    
            // Persister les entités
            $entityManager->persist($soldeDonneur);
            $entityManager->persist($soldeRecepteur);
            $entityManager->persist($transaction);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }
    
    
    

    #[Route('/{id}', name: 'app_transaction_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}