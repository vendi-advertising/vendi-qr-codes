<?php

namespace App\Entity;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

abstract class AbstractEntityWithUuidAndDateTimeCreated
{
    use Traits\IdAsUuidTrait;
    use Traits\DateTimeCreatedTrait;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->dateTimeCreated = new DateTimeImmutable();
    }
}