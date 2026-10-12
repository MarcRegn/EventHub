<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;


#[AsController]
#[Route(path: '/event/{id}', name: 'show-event', methods: ['GET'])]
class EventShow extends AbstractController
{
    public function __invoke(Event $event): Response
    {
        return $this->render('showEvent.html.twig', ['event' => $event]);
    }
}
