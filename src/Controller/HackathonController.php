<?php

namespace App\Controller;

use App\Entity\Hackathon;
use App\Form\HackathonType;
use App\Repository\HackathonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HackathonController extends AbstractController
{
    #[Route('/hackathon', name: 'hackathon_index')]
    public function index(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('hackathon/index.html.twig', [
            'hackathons' => $hackathonRepository->findAll()
        ]);
    }

    #[Route('/hackathon/create', name: 'hackathon_create')]
    public function create(Request $request, HackathonRepository $hackathonRepository): Response
    {
        $hackathon = new Hackathon();
        $form = $this->createForm(HackathonType::class, $hackathon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hackathonRepository->save($hackathon, true);

            return $this->redirectToRoute('hackathon_show', [
                'id' => $hackathon->getId()
            ]);
        }

        return $this->render('hackathon/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/hackathon/{id}', name: 'hackathon_show', requirements: ['id' => '\d'])]
    public function show(Hackathon $hackathon): Response
    {
        return $this->render('hackathon/show.html.twig', [
            'hackathon' => $hackathon
        ]);
    }
}
