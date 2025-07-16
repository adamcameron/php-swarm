<?php
namespace App\Factory;

use Ramsey\Uuid\Uuid;

class GuidFactory
{
    public function create(): string
    {
        return Uuid::uuid4()->toString();
    }
}
