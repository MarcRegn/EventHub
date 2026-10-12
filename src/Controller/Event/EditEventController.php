<?php

namespace App\Controller\Event;

use App\Entity\Event;
use App\Form\Event\EventType;
use App\Service\EditEventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Twig\Environment;

#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_ORGANIZER")'))]
#[Route(path: '/event/edit/{id}', name: 'edit-event', methods: ['GET', 'POST'])]

class EditEventController
{
    public function __invoke(Event $event, Request $request, Environment $twig, FormFactoryInterface $formFactory,EntityManagerInterface $entityManager, RouterInterface $router,Security $security, EditEventService $editEventService): Response{

        $user = $security->getUser();
        $editEventService->notCreator($event);

    /*    if (!$security->isGranted('ROLE_ADMIN')) {
            if ($event->getOrganizer()->getId() !== $user->getId()) {
                throw new AccessDeniedHttpException(
                    'Vous etes pas le createur'
                );
            }
        }
*/
        $form = $formFactory->create(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();


            return new RedirectResponse($router->generate('show-event', ['id'=> $event->getId()],
                Response::HTTP_FOUND));
        }



        return new Response($twig->render('editEvent.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
