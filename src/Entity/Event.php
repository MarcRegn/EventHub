<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\EventStatus;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[Entity(repositoryClass: EventRepository::class)]
#[Table(name: 'Event')]
class Event
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private ?int $id = null;

    #[Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank,Assert\Type('string')]
    private string $title;

    #[Column(type: 'string', length: 255, unique: true, nullable: false)]
    #[Assert\NotBlank,Assert\Type('string')]
    private string $slug;

    #[Column(type: 'text', nullable: false)]
    #[Assert\NotBlank,Assert\Type('string')]
    private string $description;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private \DateTimeImmutable $startAt;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private \DateTimeImmutable $endAt;

    #[Column(type: 'integer', nullable: false)]
    #[Assert\NotNull]
    private int $capacity;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(nullable: false)]
    private Category $category;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(nullable: false)]
    private User $organizer;

    #[Column(type: Types::STRING, length: 20, nullable: false, enumType: EventStatus::class)]
    private EventStatus $status = EventStatus::Draft;

    public function getStatus(): EventStatus{
        return $this->status;
    }

    public function getOrganizer(): User{
        return $this->organizer;
    }

    public function getCategory(): Category{
        return $this->category;
    }

    public function setCategory(Category $category): void{
        $this->category = $category;
    }
    public function setOrganizer(User $organizer): void{
        $this->organizer = $organizer;
    }


    public function setStatus(EventStatus $status): Event{
        $this->status = $status;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }


    public function getStartAt(): \DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt)
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): \DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt)
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity)
    {
        $this->capacity = $capacity;
        return $this;
    }
}

