<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain extends AbstractEntityWithUuidAndDateTimeCreated
{
    #[ORM\ManyToOne(inversedBy: 'domains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function __construct(
        #[ORM\Column(type: "string", length: 255, nullable: false)]
        public readonly string $fullyQualifiedDomainName,
    ) {
        parent::__construct();
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
