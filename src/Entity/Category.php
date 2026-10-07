<?php

namespace App\Entity;



use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[Entity(repositoryClass: CategoryRepository::class)]
#[Table(name: 'Category')]

class Category
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private ?int $id = null;

    #[Column(type: 'string', length: 100, unique: true, nullable: false)]
    #[Assert\NotBlank, Assert\Type('string')]
    private string $name;

    #[Column(type: 'string', length: 255, unique: true, nullable: false)]
    #[Assert\NotBlank, Assert\Type('string')]
    private string $slug;




    public function getId(): ?int{
        return $this->id;
    }
    public function getName(): ?string{
        return $this->name;
    }

    public function getSlug(): ?string{
        return $this->slug;
    }

    public function setName(string $name): self{
        $this->name = $name;
        return $this;
    }
    public function setSlug(string $slug): self{
        $this->slug = $slug;
        return $this;
    }

}
