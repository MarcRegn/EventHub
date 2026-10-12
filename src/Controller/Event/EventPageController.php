<?php

namespace App\Controller\Event;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;


#[AsController]
#[Route(path: '/event', name: 'list-event', methods: ['GET'])]
class EventPageController extends AbstractController
{
    public function __invoke(Environment $twig, EventRepository $eventRepository): Response
    {
        return new Response($twig->render('event.html.twig', [
            'events' => $eventRepository->findEventPublished(),
        ]), Response::HTTP_OK);
    }
}
