<?php

namespace App\Controller\Event;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
#[IsGranted('ROLE_ORGANIZER')]
#[Route(path: '/organizer/events', name: 'organizer-events', methods: ['GET'])]
class OrganizerEventsController extends AbstractController
{
    public function __invoke(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(
            ['organizer' => $this->getUser()],
        );

        return $this->render('organizerEvent.html.twig', [
            'events' => $events,
        ]);
    }
}
