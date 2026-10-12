<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Enum\RoleUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Registration;
use App\Enum\RegistrationStatus;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager):void{
        $admin = $this->user($manager, 'admin', 'admin@eventhub.test', 'azerty', [RoleUser::Admin]
        );

        $organizer1 = $this->user($manager, 'organizer', 'organizer@eventhub.test', 'azerty', [RoleUser::Organisateur]);
        $organizer2 = $this->user($manager, 'organizer2', 'organizer2@eventhub.test', 'azerty', [RoleUser::Organisateur]);
        $user = $this->user($manager, 'user', 'user@eventhub.test', 'azerty', [RoleUser::User]);

        $tech = $this->category($manager, 'Tech', 'tech');
        $sport = $this->category($manager, 'Sport', 'sport');
        $music = $this->category($manager, 'Music', 'music');


        $symfonyConf = $this->event($manager, 'Symfony Conference', 'symfony-conference', 'Evenement Symfony', $organizer1, $tech, EventStatus::Published);
        $tournoiFifa = $this->event($manager, 'Tournoi FIFA', 'tournoi-fifa', 'Competition e-sport', $organizer2, $sport, EventStatus::Draft);
        $concertJazz = $this->event($manager, 'Concert Jazz', 'concert-jazz', 'Concert live', $organizer2, $music, EventStatus::Published);

        $this->registration($manager, $user, $symfonyConf);
        $this->registration($manager, $user, $concertJazz);

        $manager->flush();
    }

    private function user(ObjectManager $manager, string $username, string $email, string $password, array $roles){

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword(
            $this->hasher->hashPassword($user, $password));
        $manager->persist($user);
        return $user;
    }

    private function category(ObjectManager $manager, string $name, string $slug){
        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $manager->persist($category);
        return $category;
    }

    private function event(
        ObjectManager $manager, string $title, string $slug, string $description, User $organizer, Category $category, EventStatus $status){

        $event = new Event();
        $event->setTitle($title);
        $event->setSlug($slug);
        $event->setDescription($description);
        $event->setOrganizer($organizer);
        $event->setCategory($category);
        $event->setStatus($status);
        $event->setCapacity(100);

        $event->setStartAt(new \DateTimeImmutable('+7 days'));
        $event->setEndAt(new \DateTimeImmutable('+7 days +2 hours'));

        $manager->persist($event);

        return $event;
    }
    private function registration(ObjectManager $manager, User $user, Event $event, RegistrationStatus $status = RegistrationStatus::Confirmed):
    Registration {
        $registration = new Registration();
        $registration->setUser($user);
        $registration->setEvent($event);
        $registration->setStatus($status);
        $manager->persist($registration);

        return $registration;
    }
}
