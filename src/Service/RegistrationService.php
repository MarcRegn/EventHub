<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Registration;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Enum\RegistrationStatus;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationService
{
    public function __construct(private readonly RegistrationRepository $registrationRepository, private readonly EntityManagerInterface $em,
    ) {
    }

    public function register(User $user, Event $event){

        if ($event->getStatus() !== EventStatus::Published) {
            return "Cet evenement n'est pas publique";
        }

        if ($this->registrationRepository->findOneBy(['user' => $user, 'event' => $event])) {
            return 'Vous etes deja inscrit';
        }

        $registration = new Registration();
        $registration->setUser($user);
        $registration->setEvent($event);
        $registration->setStatus(RegistrationStatus::Confirmed);

        $this->em->persist($registration);
        $this->em->flush();

        return(null);
    }
}
