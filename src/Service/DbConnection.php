<?php

namespace App\Service;

use PDO;

class DbConnection
{
    public function __construct(
        private readonly string $host,
        private readonly int $port,
        private readonly string $database,
        private readonly string $username,
        private readonly string $password
    ) {}

    public function getPdoConnection(): PDO
    {
        return new PDO(
            'mysql:host=' . $this->host
            . ';port=' . $this->port
            . ';dbname=' . $this->database,
            $this->username,
            $this->password
        );
    }
}
