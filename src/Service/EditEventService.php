<?php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EditEventService
{
    public function __construct(private readonly Security $security)
    {
    }

    public function notCreator(Event $event){
        $user = $this->security->getUser();

        if (!$this->security->isGranted('ROLE_ADMIN')) {
            if ($event->getOrganizer()->getId() !== $user->getId()) {
                throw new AccessDeniedHttpException(
                    'Vous n etes pas le createur'
                );
            }
        }
    }

}
