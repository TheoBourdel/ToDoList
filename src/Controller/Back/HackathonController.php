<?php

namespace App\Controller\Back;

use App\Entity\Hackathon;
use App\Form\HackathonType;
use App\Repository\HackathonRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hackathon', name: 'hackathon_')]
class HackathonController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('back/hackathon/index.html.twig', [
            'hackathons' => $hackathonRepository->findAll()
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, HackathonRepository $hackathonRepository): Response
    {
        $hackathon = new Hackathon();
        $form = $this->createForm(HackathonType::class, $hackathon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hackathonRepository->save($hackathon, true);

            return $this->redirectToRoute('back_hackathon_show', [
                'id' => $hackathon->getId()
            ]);
        }

        return $this->render('back/hackathon/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Hackathon $hackathon, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(HackathonType::class, $hackathon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->flush();

            return $this->redirectToRoute('back_hackathon_show', [
                'id' => $hackathon->getId()
            ]);
        }

        return $this->render('back/hackathon/edit.html.twig', [
            'form' => $form->createView(),
            'hackathon' => $hackathon
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d'], methods: ['GET'])]
    public function show(Hackathon $hackathon): Response
    {
        return $this->render('back/hackathon/show.html.twig', [
            'hackathon' => $hackathon,
            'test' => 'Coucou <br> test <script>alert()</script>'
        ]);
    }

    #[Route('/{id}/remove/{token}', name: 'remove', requirements: ['id' => '\d'], methods: ['GET'])]
    public function remove(Hackathon $hackathon, string $token, HackathonRepository $hackathonRepository): Response
    {
        if (!$this->isCsrfTokenValid('remove' . $hackathon->getId(), $token)) {
            throw $this->createAccessDeniedException();
        }

        $hackathonRepository->remove($hackathon, true);

        return $this->redirectToRoute('back_hackathon_index');
    }
}
