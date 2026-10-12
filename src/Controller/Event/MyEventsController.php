<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Entity\Registration;
use App\Enum\EventStatus;
use App\Enum\RegistrationStatus;
use App\Repository\RegistrationRepository;
use App\Service\RegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class MyEventsController extends AbstractController
{
    #[Route('/mes-evenements', name: 'app_my_events')]
    public function index(RegistrationRepository $repository): Response
    {
        $registrations = $repository->findBy(['user' => $this->getUser()]);

        return $this->render('my_events/index.html.twig', [
            'registrations' => $registrations,
        ]);
    }


    #[Route('/evenements/{id}/inscription', name: 'register-event', methods: ['POST'])]
    public function register(Event $event, RegistrationService $registrationService): Response
    {
        $error = $registrationService->register($this->getUser(), $event);

        if ($error) {
            $this->addFlash('error', $error);
        } else {
            $this->addFlash('success', 'Vous êtes inscrit');
        }

        return $this->redirectToRoute('app_my_events');
    }
}
