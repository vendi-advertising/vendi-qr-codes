<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait IdAsUuidTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    protected Uuid $id;

    final public function getId(): Uuid
    {
        return $this->id;
    }
}