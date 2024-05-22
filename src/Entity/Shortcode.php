<?php

namespace App\Entity;

use App\Repository\ShortcodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShortcodeRepository::class)]
class Shortcode extends AbstractEntityWithUuidAndDateTimeCreated
{
    public function __construct(
        #[ORM\Column(type: "string", length: 255, nullable: false)]
        public readonly string $url,

        #[ORM\Column(type: "string", length: 255, nullable: false)]
        public readonly string $shortcode,

        #[ORM\ManyToOne]
        public ?Domain $domain = null,
    ) {
        parent::__construct();
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): static
    {
        $this->domain = $domain;

        return $this;
    }
}