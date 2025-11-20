<?php

namespace App\Controller;

use App\Entity\Spool;
use App\Form\SpoolType;
use App\Repository\SpoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spool')]
final class SpoolController extends AbstractController
{
    #[Route(name: 'app_spool_index', methods: ['GET'])]
    public function index(SpoolRepository $spoolRepository): Response
    {
        return $this->render('spool/index.html.twig', [
            'spools' => $spoolRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spool_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spool = new Spool();
        $form = $this->createForm(SpoolType::class, $spool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spool);
            $entityManager->flush();

            return $this->redirectToRoute('app_spool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spool/new.html.twig', [
            'spool' => $spool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spool_show', methods: ['GET'])]
    public function show(Spool $spool): Response
    {
        return $this->render('spool/show.html.twig', [
            'spool' => $spool,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spool_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Spool $spool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpoolType::class, $spool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spool_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spool/edit.html.twig', [
            'spool' => $spool,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spool_delete', methods: ['POST'])]
    public function delete(Request $request, Spool $spool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spool->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spool_index', [], Response::HTTP_SEE_OTHER);
    }
}
