<?php

namespace App\Controller\Event;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Form\Event\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use function PHPUnit\Framework\throwException;

#[AsController]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_ORGANIZER")'))]
#[Route('/create-event', name: 'create-event', methods: ['GET', 'POST'])]

class CreateEventController
{

    public function __invoke(Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, SluggerInterface $slugger, Security $security,Environment $twig): Response
    {

        $user = $security->getUser();
        $event = new Event();

        $form = $formFactory->create(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();
            $event->setSlug($slugger->slug($event->getTitle())->lower()->toString());
            if (!$user instanceof User ){
                throw new AccessDeniedHttpException('Interdit');
            }
            $event->setOrganizer($user);
            $event->setStatus(EventStatus::Published);
            $entityManager->persist($event);
            $entityManager->flush();

        }
        return new Response($twig->render('addEvent.html.twig', [
            'form' => $form->createView(),
        ]), Response::HTTP_OK);
    }
}
