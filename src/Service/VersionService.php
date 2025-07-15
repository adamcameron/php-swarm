<?php

namespace App\Service;

class VersionService
{
    public function __construct(
        private readonly DbConnection $dbConnection
    )
    {}

    public function getVersion(): string
    {
        return $this->dbConnection
            ->getPdoConnection()
            ->query('SELECT @@VERSION')
            ->fetchColumn() ?: 'unknown';
    }
}
