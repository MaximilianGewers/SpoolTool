<?php

namespace App\Controller;

use App\Entity\SpoolBrand;
use App\Form\SpoolBrandType;
use App\Repository\SpoolBrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spool/brand')]
final class SpoolBrandController extends AbstractController
{
    #[Route(name: 'app_spool_brand_index', methods: ['GET'])]
    public function index(SpoolBrandRepository $spoolBrandRepository): Response
    {
        return $this->render('spool_brand/index.html.twig', [
            'spool_brands' => $spoolBrandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spool_brand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spoolBrand = new SpoolBrand();
        $form = $this->createForm(SpoolBrandType::class, $spoolBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spoolBrand);
            $entityManager->flush();

            return $this->redirectToRoute('app_spool_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spool_brand/new.html.twig', [
            'spool_brand' => $spoolBrand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spool_brand_show', methods: ['GET'])]
    public function show(SpoolBrand $spoolBrand): Response
    {
        return $this->render('spool_brand/show.html.twig', [
            'spool_brand' => $spoolBrand,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spool_brand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpoolBrand $spoolBrand, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpoolBrandType::class, $spoolBrand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spool_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spool_brand/edit.html.twig', [
            'spool_brand' => $spoolBrand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spool_brand_delete', methods: ['POST'])]
    public function delete(Request $request, SpoolBrand $spoolBrand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spoolBrand->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spoolBrand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spool_brand_index', [], Response::HTTP_SEE_OTHER);
    }
}
